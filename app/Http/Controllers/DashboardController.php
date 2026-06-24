<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Country;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\PettyCash;
use App\Models\Portal;
use App\Models\PortalBalance;
use App\Models\Purpose;
use App\Models\Sale;
use App\Models\ServiceType;
use App\Models\Tour;
use App\Models\Training;
use App\Models\TrainingType;
use App\Models\Trip;
use App\Models\User;
use App\Models\Visa;
use App\Models\VisaPurpose;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $request = request();
        $user = auth()->user();

        // only admins and superadmins see full dashboard data
        if (! in_array($user->user_type, ['admin', 'superadmin'])) {
            return view('dashboard');
        }

        $now = Carbon::now();
        $currentMonth = $now->format('Y-m');

        // Parse date range from request (start_date and end_date expected)
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate && $endDate) {
            try {
                $start = Carbon::parse($startDate)->startOfDay();
                $end = Carbon::parse($endDate)->endOfDay();
            } catch (\Exception $e) {
                $start = $now->copy()->subMonths(5)->startOfMonth();
                $end = $now->copy()->endOfDay();
            }
        } else {
            // default to last 6 months
            $start = $now->copy()->subMonths(5)->startOfMonth();
            $end = $now->copy()->endOfDay();
        }

        // ---- Summary counts and totals for dashboard cards ----
        $totalUsers = User::count();
        $totalSales = Sale::count();
        // $totalTrips = Trip::count();
        $totalTours = Tour::count();
        $totalVisas = Visa::count();
        $totalAirlines = Airline::count();
        // $totalServiceTypes = ServiceType::count();
        // $totalCountries = Country::count();
        $totalPortals = Portal::count();
        // $totalPortalTransactions = PortalBalance::count();
        // $totalPetty = PettyCash::count();
        $pettyBalance = PettyCash::balance();
        $totalTrainings = Training::count();

        // Total dues for modules that track customer_due (apply date range when provided)
        $salesDue = Sale::sum('customer_due');
        $trainingsDue = Training::sum('customer_due');
        $toursDue = Tour::sum('customer_due');
        $visasDue = Visa::sum('customer_due');

        // Expenses for current month and last month (also count)
        $totalExpensesThisMonth = Expense::whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->sum('amount');

        // $expenseCountThisMonth = Expense::whereYear('date', $now->year)
        //     ->whereMonth('date', $now->month)
        //     ->count();

        $totalExpensesLastMonth = Expense::whereYear('date', $now->copy()->subMonth()->year)
            ->whereMonth('date', $now->copy()->subMonth()->month)
            ->sum('amount');

        // $expenseCountLastMonth = Expense::whereYear('date', $now->copy()->subMonth()->year)
        //     ->whereMonth('date', $now->copy()->subMonth()->month)
        //     ->count();

        // ---- Expense vs Sales chart ----
        // $expensesByMonth = Expense::selectRaw(
        //     "DATE_FORMAT(date, '%Y-%m') as expense_month, SUM(amount) as total_expense"
        // )
        //     ->groupBy('expense_month')
        //     ->orderByDesc('expense_month')
        //     ->get()
        //     ->keyBy('expense_month');

        // $salesByMonth = Sale::selectRaw(
        //     "DATE_FORMAT(created_at, '%Y-%m') as sale_month, SUM(customer_fare) as total_sales, COUNT(*) as sales_count"
        // )
        //     ->groupBy('sale_month')
        //     ->orderByDesc('sale_month')
        //     ->get()
        //     ->keyBy('sale_month');

        // ---- Combined report summary for important modules ----
        $reportSummaryMonth = $request->input('report_summary_month');
        $reportSummaryYear = $request->input('report_summary_year');

        if ($reportSummaryMonth && $reportSummaryYear) {
            try {
                // Create start and end dates for the specified month/year
                $summaryStart = Carbon::createFromDate($reportSummaryYear, $reportSummaryMonth, 1)->startOfMonth()->startOfDay();
                $summaryEnd = Carbon::createFromDate($reportSummaryYear, $reportSummaryMonth, 1)->endOfMonth()->endOfDay();
            } catch (\Exception $e) {
                $summaryStart = $start;
                $summaryEnd = $end;
            }
        } else {
            $summaryStart = $start;
            $summaryEnd = $end;
        }

        $reportSummaryDataFiltered = $this->generateMonthlyReport($summaryStart, $summaryEnd);
        $reportSummaryDisplayMonth = $reportSummaryMonth ? $reportSummaryMonth : $now->month;
        $reportSummaryDisplayYear = $reportSummaryYear ? $reportSummaryYear : $now->year;

        // ---- Module-specific reports ----
        $salesReport = Portal::orderBy('name')->get()->map(function ($p) use ($start, $end) {
            $q = Sale::query();
            if ($start && $end) {
                $q->whereBetween('issue_date', [$start, $end]);
            }
            $q->where(function ($qq) use ($p) {
                $qq->where('issued_portal', $p->id)->orWhere('issued_portal', $p->name);
            });

            // Calculate totals, profit and net profit (profit = customer_fare - agent_fare, net_profit = profit + segment_fare)
            $row = $q->selectRaw(
                'COUNT(*) as count,
                COALESCE(SUM(profit), 0) as profit,
                COALESCE(SUM(profit + COALESCE(segment_fare, 0)), 0) as net_profit'
            )->first();

            if (! $row) {
                $row = (object) ['count' => 0, 'total' => 0, 'profit' => 0, 'net_profit' => 0];
            }

            return (object) [
                'label' => $p->name,
                'count' => (int) $row->count,
                'profit' => (float) $row->profit,
                'net_profit' => (float) $row->net_profit,
            ];
        });

        $portalBalancesReport = Portal::orderBy('name')->get()->map(function ($p) use ($start, $end) {
            $q = PortalBalance::query();

            if ($start && $end) {
                $q->whereBetween('date', [$start, $end]);
            }

            // Match by ID or Name
            $q->where(function ($qq) use ($p) {
                $qq->where('portal', $p->id)->orWhere('portal', $p->name);
            });

            // We sum recharges (credit) and sales (debit) separately in one query
            $row = $q->selectRaw("
                COUNT(*) as count,
                SUM(CASE WHEN transaction_type = 'credit' THEN recharge ELSE 0 END) as total_credits,
                SUM(CASE WHEN transaction_type = 'debit' THEN recharge ELSE 0 END) as total_debits
            ")->first();

            $credits = (float) ($row->total_credits ?? 0);
            $debits = (float) ($row->total_debits ?? 0);

            // Balance = Total Money In - Total Money Out
            $currentBalance = $credits - $debits;

            return (object) [
                'label' => $p->name,
                'count' => (int) $row->count,
                'total' => $credits,        // Total Recharges
                'sales' => $debits,         // Total Debits/Sales
                'current' => $currentBalance, // Remaining Balance
            ];
        });

        // total current balance across all portals
        $totalPortalCurrent = $portalBalancesReport->sum(function ($r) {
            return $r->current ?? 0;
        });

        $toursReport = Purpose::orderBy('name')->get()->map(function ($p) use ($start, $end) {
            $q = Tour::query();
            if ($start && $end) {
                $q->whereBetween('purchase_date', [$start, $end]);
            }
            $q->where(function ($qq) use ($p) {
                $qq->where('purpose', $p->id)->orWhere('purpose', $p->name);
            });
            $row = $q->selectRaw(
                'COUNT(*) as count,
                COALESCE(SUM(COALESCE(customer_price,0)),0) as total_customer_price,
                COALESCE(SUM(COALESCE(agent_cost,0)),0) as total_agent_cost,
                COALESCE(SUM(profit), 0) as profit'
            )->first();
            if (! $row) {
                $row = (object) ['count' => 0, 'profit' => 0, 'total_customer_price' => 0, 'total_agent_cost' => 0];
            }

            return (object) [
                'label' => $p->name,
                'count' => (int) $row->count,
                'customer_price' => (float) $row->total_customer_price,
                'agent_cost' => (float) $row->total_agent_cost,
                'profit' => (float) $row->profit,
            ];
        });

        $visasReport = VisaPurpose::orderBy('name')->get()->map(function ($p) use ($start, $end) {
            $q = Visa::query();
            if ($start && $end) {
                $q->whereBetween('purchase_date', [$start, $end]);
            }
            $q->where(function ($qq) use ($p) {
                $qq->where('purpose', $p->id)->orWhere('purpose', $p->name);
            });
            $row = $q->selectRaw(
                'COUNT(*) as count,
                COALESCE(SUM(COALESCE(customer_price,0)),0) as total_customer_price,
                COALESCE(SUM(COALESCE(agent_cost,0)),0) as total_agent_cost,
                COALESCE(SUM(profit), 0) as profit'
            )->first();
            if (! $row) {
                $row = (object) ['count' => 0, 'profit' => 0, 'total_customer_price' => 0, 'total_agent_cost' => 0];
            }

            return (object) [
                'label' => $p->name,
                'count' => (int) $row->count,
                'customer_price' => (float) $row->total_customer_price,
                'agent_cost' => (float) $row->total_agent_cost,
                'profit' => (float) $row->profit,
            ];
        });

        $trainingsReport = TrainingType::orderBy('name')->get()->map(function ($t) use ($start, $end) {
            $q = Training::query();
            if ($start && $end) {
                $q->whereBetween('purchase_date', [$start, $end]);
            }
            $q->where(function ($qq) use ($t) {
                $qq->where('training_type', $t->id)->orWhere('training_type', $t->name);
            });
            $row = $q->selectRaw('COUNT(*) as count, COALESCE(SUM(COALESCE(customer_price,0)),0) as total_customer_price, COALESCE(SUM(COALESCE(agent_cost,0)),0) as total_agent_cost')->first();
            if (! $row) {
                $row = (object) ['count' => 0, 'total_customer_price' => 0, 'total_agent_cost' => 0];
            }

            return (object) [
                'label' => $t->name,
                'count' => (int) $row->count,
                'customer_price' => (float) $row->total_customer_price,
                'agent_cost' => (float) $row->total_agent_cost,
                'total' => (float) $row->total_customer_price,
            ];
        });

        $expensesReport = ExpenseType::orderBy('name')->get()->map(function ($c) use ($start, $end) {
            $q = Expense::query();
            if ($start && $end) {
                $q->whereBetween('date', [$start, $end]);
            }
            $q->where('expense_type_id', $c->id);
            $row = $q->selectRaw('COUNT(*) as count, COALESCE(SUM(amount),0) as total')->first();
            if (! $row) {
                $row = (object) ['count' => 0, 'total' => 0];
            }

            return (object) [
                'label' => $c->name,
                'count' => (int) $row->count,
                'total' => (float) $row->total,
            ];
        });

        // Map expense category id to name (keep for backward compatibility)
        $expenseCategoryMap = ExpenseType::pluck('name', 'id')->toArray();

        // Calculate totals for each report
        $salesReportSums = $this->calculateSalesReportSums($salesReport);
        $portalBalancesReportSums = $this->calculatePortalBalancesReportSums($portalBalancesReport);
        $toursReportSums = $this->calculateToursReportSums($toursReport);
        $visasReportSums = $this->calculateVisasReportSums($visasReport);
        $trainingsReportSums = $this->calculateTrainingsReportSums($trainingsReport);
        $expensesReportSums = $this->calculateExpensesReportSums($expensesReport);

        // ---- Recent activity (latest 5 records for each module) ----
        $recentExpenses = Expense::with('user')->latest()->take(5)->get();
        $recentSales = Sale::latest()->take(5)->get();
        $recentTours = Tour::latest()->take(5)->get();
        $recentVisas = Visa::latest()->take(5)->get();
        $recentTrainings = Training::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('dashboard', [
            'user' => $user,
            'totalUsers' => $totalUsers,
            'totalSales' => $totalSales,
            // 'totalTrips' => $totalTrips,
            'totalTours' => $totalTours,
            'totalVisas' => $totalVisas,
            'totalTrainings' => $totalTrainings,
            'totalAirlines' => $totalAirlines,
            // 'totalServiceTypes' => $totalServiceTypes,
            // 'totalCountries' => $totalCountries,
            'totalPortals' => $totalPortals,
            // 'totalPortalTransactions' => $totalPortalTransactions,
            // 'totalPetty' => $totalPetty,
            'pettyBalance' => $pettyBalance,
            'totalExpensesThisMonth' => $totalExpensesThisMonth,
            // 'expenseCountThisMonth' => $expenseCountThisMonth,
            'totalExpensesLastMonth' => $totalExpensesLastMonth,
            // 'expenseCountLastMonth' => $expenseCountLastMonth,
            'recentExpenses' => $recentExpenses,
            'recentSales' => $recentSales,
            'recentTours' => $recentTours,
            'recentVisas' => $recentVisas,
            'recentTrainings' => $recentTrainings,
            'recentUsers' => $recentUsers,
            // 'expensesByMonth' => $expensesByMonth->values(),
            // 'salesByMonth' => $salesByMonth->values(),
            'currentMonth' => $currentMonth,
            'startDate' => $start->toDateString(),
            'endDate' => $end->toDateString(),
            'salesReport' => $salesReport,
            'salesReportSums' => $salesReportSums,
            'portalBalancesReport' => $portalBalancesReport,
            'portalBalancesReportSums' => $portalBalancesReportSums,
            'totalPortalCurrent' => $totalPortalCurrent,
            'toursReport' => $toursReport,
            'toursReportSums' => $toursReportSums,
            'visasReport' => $visasReport,
            'visasReportSums' => $visasReportSums,
            'trainingsReport' => $trainingsReport,
            'trainingsReportSums' => $trainingsReportSums,
            'expensesReport' => $expensesReport,
            'expensesReportSums' => $expensesReportSums,
            'expenseCategoryMap' => $expenseCategoryMap,
            'salesDue' => $salesDue,
            'trainingsDue' => $trainingsDue,
            'toursDue' => $toursDue,
            'visasDue' => $visasDue,
            'reportSummaryDataFiltered' => $reportSummaryDataFiltered,
            'reportSummaryDisplayMonth' => $reportSummaryDisplayMonth,
            'reportSummaryDisplayYear' => $reportSummaryDisplayYear,
        ]);
    }

    /**
     * Generate monthly summary report data for all categories
     * Profit is calculated dynamically: Tours/Visas/Training = customer_price - agent_cost
     */
    private function generateMonthlyReport($startDate, $endDate)
    {
        // Helper function to calculate profit
        $calculateSalesProfit = function ($query) {
            return $query->selectRaw('COALESCE(SUM(COALESCE(profit, 0) + COALESCE(segment_fare, 0)), 0) as profit')->first()->profit ?? 0;
        };

        $calculateTourProfit = function ($query) {
            return $query->sum('profit');
        };

        $calculateVisaProfit = function ($query) {
            return $query->sum('profit');
        };

        $calculateTrainingProfit = function ($query) {
            return $query->selectRaw('COALESCE(SUM(COALESCE(customer_price,0) - COALESCE(agent_cost,0)), 0) as profit')->first()->profit ?? 0;
        };

        $categories = [
            [
                'key' => 'ticket',
                'label' => 'Sum of All Ticket Sales',
                'sales' => Sale::whereBetween('issue_date', [$startDate, $endDate])->sum('customer_fare'),
                'purchase' => Sale::whereBetween('issue_date', [$startDate, $endDate])->sum('agent_fare'),
                'profit' => $calculateSalesProfit(Sale::whereBetween('issue_date', [$startDate, $endDate])),
                'due' => Sale::whereBetween('issue_date', [$startDate, $endDate])->sum('customer_due'),
            ],
            [
                'key' => 'ticket_issued',
                'label' => 'Total Issue',
                'sales' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Issue')->sum('customer_fare'),
                'purchase' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Issue')->sum('agent_fare'),
                'profit' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Issue')->sum('profit'),
                'due' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Issue')->sum('customer_due'),
            ],
            [
                'key' => 'segment',
                'label' => 'Total Segment',
                'sales' => null,
                'purchase' => null,
                'profit' => Sale::whereBetween('issue_date', [$startDate, $endDate])->whereIn('service_type', ['Issue', 'Reissue'])->sum('segment_fare'),
                'due' => null,
            ],
            [
                'key' => 'reissue',
                'label' => 'Total Reissue',
                'sales' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Reissue')->sum('customer_fare'),
                'purchase' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Reissue')->sum('agent_fare'),
                'profit' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Reissue')->sum('profit'),
                'due' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Reissue')->sum('customer_due'),
            ],
            [
                'key' => 'void',
                'label' => 'Total Void',
                'sales' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Void')->sum('customer_fare'),
                'purchase' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Void')->sum('agent_fare'),
                'profit' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Void')->sum('profit'),
                'due' => null,
            ],
            [
                'key' => 'refund',
                'label' => 'Total Refund',
                'sales' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Refund')->sum('customer_fare'),
                'purchase' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Refund')->sum('agent_fare'),
                'profit' => 0,
                'due' => Sale::whereBetween('issue_date', [$startDate, $endDate])->where('service_type', 'Refund')->sum('customer_due'),
            ],
            [
                'key' => 'tour',
                'label' => 'Sum of All Tour & Travel',
                'sales' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->sum('customer_price'),
                'purchase' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->sum('agent_cost'),
                'profit' => $calculateTourProfit(Tour::whereBetween('purchase_date', [$startDate, $endDate])),
                'due' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->sum('customer_due'),
            ],
            [
                'key' => 'hotel',
                'label' => 'Total Hotel Booking',
                'sales' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Hotel / Resort Booking')->sum('customer_price'),
                'purchase' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Hotel / Resort Booking')->sum('agent_cost'),
                'profit' => $calculateTourProfit(Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Hotel / Resort Booking')),
                'due' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Hotel / Resort Booking')->sum('customer_due'),
            ],
            [
                'key' => 'car',
                'label' => 'Total Car Booking',
                'sales' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Car / Bus Booking')->sum('customer_price'),
                'purchase' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Car / Bus Booking')->sum('agent_cost'),
                'profit' => $calculateTourProfit(Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Car / Bus Booking')),
                'due' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Car / Bus Booking')->sum('customer_due'),
            ],
            [
                'key' => 'local',
                'label' => 'Total Local Tour',
                'sales' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Local Tour')->sum('customer_price'),
                'purchase' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Local Tour')->sum('agent_cost'),
                'profit' => $calculateTourProfit(Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Local Tour')),
                'due' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Local Tour')->sum('customer_due'),
            ],
            [
                'key' => 'intl',
                'label' => 'Total International Tour',
                'sales' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'International Tour')->sum('customer_price'),
                'purchase' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'International Tour')->sum('agent_cost'),
                'profit' => $calculateTourProfit(Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'International Tour')),
                'due' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'International Tour')->sum('customer_due'),
            ],
            [
                'key' => 'ship',
                'label' => 'Ship',
                'sales' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Ship')->sum('customer_price'),
                'purchase' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Ship')->sum('agent_cost'),
                'profit' => $calculateTourProfit(Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Ship')),
                'due' => Tour::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Ship')->sum('customer_due'),
            ],
            [
                'key' => 'visa',
                'label' => 'Sum of All Visa & Consultancy',
                'sales' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->sum('customer_price'),
                'purchase' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->sum('agent_cost'),
                'profit' => $calculateVisaProfit(Visa::whereBetween('purchase_date', [$startDate, $endDate])),
                'due' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->sum('customer_due'),
            ],
            [
                'key' => 'visa_career',
                'label' => 'Visa',
                'sales' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Visa')->sum('customer_price'),
                'purchase' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Visa')->sum('agent_cost'),
                'profit' => $calculateVisaProfit(Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Visa')),
                'due' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Visa')->sum('customer_due'),
            ],
            [
                'key' => 'carrer',
                'label' => 'Career',
                'sales' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Career Consultancy')->sum('customer_price'),
                'purchase' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Career Consultancy')->sum('agent_cost'),
                'profit' => $calculateVisaProfit(Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Career Consultancy')),
                'due' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Career Consultancy')->sum('customer_due'),
            ],
            [
                'key' => 'hajj',
                'label' => 'Hajj',
                'sales' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Hajj')->sum('customer_price'),
                'purchase' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Hajj')->sum('agent_cost'),
                'profit' => $calculateVisaProfit(Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Hajj')),
                'due' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Hajj')->sum('customer_due'),
            ],
            [
                'key' => 'umrah',
                'label' => 'Umrah Hajj',
                'sales' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Umrah Hajj')->sum('customer_price'),
                'purchase' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Umrah Hajj')->sum('agent_cost'),
                'profit' => $calculateVisaProfit(Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Umrah Hajj')),
                'due' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Umrah Hajj')->sum('customer_due'),
            ],
            [
                'key' => 'student',
                'label' => 'Student',
                'sales' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Student Consultancy')->sum('customer_price'),
                'purchase' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Student Consultancy')->sum('agent_cost'),
                'profit' => $calculateVisaProfit(Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Student Consultancy')),
                'due' => Visa::whereBetween('purchase_date', [$startDate, $endDate])->where('purpose', 'Student Consultancy')->sum('customer_due'),
            ],
            [
                'key' => 'training',
                'label' => 'Sum of All Training',
                'sales' => Training::whereBetween('purchase_date', [$startDate, $endDate])->sum('customer_price'),
                'purchase' => Training::whereBetween('purchase_date', [$startDate, $endDate])->sum('agent_cost'),
                'profit' => $calculateTrainingProfit(Training::whereBetween('purchase_date', [$startDate, $endDate])),
                'due' => Training::whereBetween('purchase_date', [$startDate, $endDate])->sum('customer_due'),
            ],
        ];

        // Transform data to match view expectations
        return collect($categories)->map(function ($category) {
            return [
                'key' => $category['key'],
                'label' => $category['label'],
                'total_sales' => $category['sales'],
                'total_purchase' => $category['purchase'],
                'profit' => $category['profit'],
                'total_due' => $category['due'],
            ];
        })->toArray();
    }

    /**
     * Calculate totals for Sales Report
     */
    private function calculateSalesReportSums($salesReport)
    {
        return (object) [
            'totalCount' => collect($salesReport)->sum('count'),
            'totalProfit' => collect($salesReport)->sum('profit'),
            'totalNetProfit' => collect($salesReport)->sum('net_profit'),
        ];
    }

    /**
     * Calculate totals for Portal Balances Report
     */
    private function calculatePortalBalancesReportSums($portalBalancesReport)
    {
        return (object) [
            'totalCount' => collect($portalBalancesReport)->sum('count'),
            'totalRecharge' => collect($portalBalancesReport)->sum('total'),
            'totalCurrent' => collect($portalBalancesReport)->sum('current'),
        ];
    }

    /**
     * Calculate totals for Tours Report
     */
    private function calculateToursReportSums($toursReport)
    {
        return (object) [
            'totalCount' => collect($toursReport)->sum('count'),
            'totalCustomerPrice' => collect($toursReport)->sum('customer_price'),
            'totalAgentCost' => collect($toursReport)->sum('agent_cost'),
            'totalProfit' => collect($toursReport)->sum('profit'),
        ];
    }

    /**
     * Calculate totals for Visas Report
     */
    private function calculateVisasReportSums($visasReport)
    {
        return (object) [
            'totalCount' => collect($visasReport)->sum('count'),
            'totalCustomerPrice' => collect($visasReport)->sum('customer_price'),
            'totalAgentCost' => collect($visasReport)->sum('agent_cost'),
            'totalProfit' => collect($visasReport)->sum('profit'),
        ];
    }

    /**
     * Calculate totals for Trainings Report
     */
    private function calculateTrainingsReportSums($trainingsReport)
    {
        return (object) [
            'totalCount' => collect($trainingsReport)->sum('count'),
            'totalCustomerPrice' => collect($trainingsReport)->sum('customer_price'),
            'totalAgentCost' => collect($trainingsReport)->sum('agent_cost'),
            'totalAmount' => collect($trainingsReport)->sum('total'),
        ];
    }

    /**
     * Calculate totals for Expenses Report
     */
    private function calculateExpensesReportSums($expensesReport)
    {
        return (object) [
            'totalCount' => collect($expensesReport)->sum('count'),
            'totalExpenses' => collect($expensesReport)->sum('total'),
        ];
    }
}
