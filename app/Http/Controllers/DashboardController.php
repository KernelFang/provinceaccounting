<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Flat;
use App\Models\Income;
use App\Models\PaymentMethod;
use App\Models\PettyCash;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $user = auth()->user();

        // only admins and superadmins see full dashboard data
        if (! in_array($user->user_type, ['admin', 'superadmin'])) {
            return view('dashboard');
        }

        $now = Carbon::now();

        // ---- Summary counts for dashboard cards ----
        $totalUsers = User::count();
        $totalClients = Client::count();
        $totalProjects = Project::count();
        $totalFlats = Flat::count();
        $totalIncomes = Income::count();
        $totalPaymentMethods = PaymentMethod::count();
        $pettyBalance = PettyCash::balance();

        // Expenses for current month and last month
        $totalExpensesThisMonth = Expense::whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->sum('amount');

        $totalExpensesLastMonth = Expense::whereYear('date', $now->copy()->subMonth()->year)
            ->whereMonth('date', $now->copy()->subMonth()->month)
            ->sum('amount');

        // Income totals
        $totalIncomeThisMonth = Income::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('price');

        $totalIncomeLastMonth = Income::whereYear('created_at', $now->copy()->subMonth()->year)
            ->whereMonth('created_at', $now->copy()->subMonth()->month)
            ->sum('price');

        // Total income across all time
        $totalIncomeAllTime = Income::sum('price');

        // Expenses by type
        $expensesReport = ExpenseType::orderBy('name')->get()->map(function ($c) {
            $q = Expense::where('expense_type_id', $c->id);
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

        $expensesReportSums = $this->calculateExpensesReportSums($expensesReport);

        // Recent activity (latest 5 records for each module)
        $recentExpenses = Expense::with('user')->latest()->take(5)->get();
        $recentIncomes = Income::latest()->take(5)->get();
        $recentClients = Client::latest()->take(5)->get();
        $recentProjects = Project::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        // Projects by status
        $projectsByStatus = Project::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Flats by project
        $flatsByProject = Project::withCount('flats')->orderBy('flats_count', 'desc')->take(5)->get();

        // Income by payment method
        $incomeByPaymentMethod = PaymentMethod::withCount('incomes')
            ->orderBy('incomes_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', [
            'user' => $user,
            'totalUsers' => $totalUsers,
            'totalClients' => $totalClients,
            'totalProjects' => $totalProjects,
            'totalFlats' => $totalFlats,
            'totalIncomes' => $totalIncomes,
            'totalPaymentMethods' => $totalPaymentMethods,
            'pettyBalance' => $pettyBalance,
            'totalExpensesThisMonth' => $totalExpensesThisMonth,
            'totalExpensesLastMonth' => $totalExpensesLastMonth,
            'totalIncomeThisMonth' => $totalIncomeThisMonth,
            'totalIncomeLastMonth' => $totalIncomeLastMonth,
            'totalIncomeAllTime' => $totalIncomeAllTime,
            'recentExpenses' => $recentExpenses,
            'recentIncomes' => $recentIncomes,
            'recentClients' => $recentClients,
            'recentProjects' => $recentProjects,
            'recentUsers' => $recentUsers,
            'expensesReport' => $expensesReport,
            'expensesReportSums' => $expensesReportSums,
            'projectsByStatus' => $projectsByStatus,
            'flatsByProject' => $flatsByProject,
            'incomeByPaymentMethod' => $incomeByPaymentMethod,
        ]);
    }

    /**
     * Calculate totals for expenses report
     */
    private function calculateExpensesReportSums($expensesReport)
    {
        return (object) [
            'total_count' => collect($expensesReport)->sum('count'),
            'total_amount' => collect($expensesReport)->sum('total'),
        ];
    }
}
