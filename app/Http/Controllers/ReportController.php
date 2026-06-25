<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Expense;
use App\Models\Flat;
use App\Models\Income;
use App\Models\Project;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (! in_array($user->user_type, ['admin', 'superadmin'])) {
            return view('reports.index', [
                'modules' => $this->moduleOptions(),
                'projects' => Project::orderBy('name')->get(),
                'clients' => Client::orderBy('first_name')->get(),
                'flats' => Flat::with('project')->orderBy('project_id')->orderBy('flat_no')->get(),
                'statuses' => ['pending', 'completed', 'ongoing', 'cancelled'],
                'report' => null,
                'filters' => $request->only(['module', 'item_id', 'group_by', 'order_by', 'from_date', 'to_date', 'status']),
            ]);
        }

        $module = $request->input('module');
        $report = null;
        $filters = $request->only(['module', 'item_id', 'group_by', 'order_by', 'from_date', 'to_date', 'status']);

        if ($module) {
            $report = $this->buildReport($module, $request);
        }

        return view('reports.index', [
            'modules' => $this->moduleOptions(),
            'projects' => Project::orderBy('name')->get(),
            'clients' => Client::orderBy('first_name')->get(),
            'flats' => Flat::with('project')->orderBy('project_id')->orderBy('flat_no')->get(),
            'statuses' => ['pending', 'completed', 'ongoing', 'cancelled'],
            'report' => $report,
            'filters' => $filters,
        ]);
    }

    protected function buildReport(string $module, Request $request): array
    {
        $itemId = $request->input('item_id');

        if ($itemId) {
            $detailReport = $this->buildDetailReport($module, (int) $itemId);

            if ($detailReport !== null) {
                return $detailReport;
            }
        }

        $query = match ($module) {
            'projects' => Project::query(),
            'clients' => Client::query(),
            'flats' => Flat::query()->with(['project', 'currentOwner']),
            'incomes' => Income::query()->with(['project', 'client', 'paymentMethod']),
            'expenses' => Expense::query()->with(['project', 'expenseType', 'paymentMethod']),
            default => Project::query(),
        };

        $query = $this->applyDateFilter($query, $request, $module);
        $query = $this->applyItemFilter($query, $request, $module);
        $query = $this->applyStatusFilter($query, $request, $module);

        $records = $query->get();

        $labels = $this->labelsFor($module, $records);
        $totals = $this->totalsFor($module, $records);

        return [
            'module' => $module,
            'records' => $records,
            'labels' => $labels,
            'totals' => $totals,
            'grouped' => $this->groupRecords($records, $request->input('group_by')),
            'item' => null,
            'item_label' => null,
            'title' => 'Generated Report',
            'sections' => [],
        ];
    }

    protected function buildDetailReport(string $module, int $itemId): ?array
    {
        return match ($module) {
            'projects' => $this->buildProjectDetailReport($itemId),
            'clients' => $this->buildClientDetailReport($itemId),
            'flats' => $this->buildFlatDetailReport($itemId),
            'incomes' => $this->buildIncomeDetailReport($itemId),
            'expenses' => $this->buildExpenseDetailReport($itemId),
            default => null,
        };
    }

    protected function buildProjectDetailReport(int $projectId): ?array
    {
        $project = Project::with(['flats.currentOwner', 'flats.pricingHistories', 'incomes.client', 'incomes.paymentMethod', 'expenses.expenseType', 'expenses.paymentMethod'])->find($projectId);

        if (! $project) {
            return null;
        }

        $flatRecords = $project->flats()->with(['currentOwner', 'pricingHistories'])->get();
        $incomeRecords = $project->incomes()->with(['client', 'paymentMethod'])->get();
        $expenseRecords = $project->expenses()->with(['expenseType', 'paymentMethod'])->get();

        $incomeTotal = $incomeRecords->sum('price');
        $expenseTotal = $expenseRecords->sum('amount');
        $net = $incomeTotal - $expenseTotal;
        $flatCount = $flatRecords->count();
        $soldFlats = $flatRecords->where('current_owner_id', '!=', null)->count();
        $vacantFlats = $flatCount - $soldFlats;
        $progressPercent = $flatCount > 0 ? round(($soldFlats / $flatCount) * 100, 2) : 0;

        return [
            'module' => 'projects',
            'records' => collect([$project]),
            'labels' => [$project->name],
            'totals' => [
                'project_count' => 1,
                'flat_count' => $flatCount,
                'sold_flats' => $soldFlats,
                'vacant_flats' => $vacantFlats,
                'income_total' => $incomeTotal,
                'expense_total' => $expenseTotal,
                'net_balance' => $net,
                'progress_percent' => $progressPercent,
            ],
            'grouped' => [],
            'item' => $project,
            'item_label' => $project->name,
            'title' => 'Project Lifecycle Report',
            'sections' => [
                [
                    'title' => 'Overview',
                    'type' => 'summary',
                    'rows' => [
                        ['label' => 'Name', 'value' => $project->name],
                        ['label' => 'Status', 'value' => $project->status ?? 'N/A'],
                        ['label' => 'Location', 'value' => $project->location ?? 'N/A'],
                        ['label' => 'Progress', 'value' => $progressPercent.'%'],
                    ],
                ],
                [
                    'title' => 'Flats',
                    'type' => 'list',
                    'rows' => $flatRecords->map(fn ($flat) => $flat->building_no.'-'.$flat->flat_no.' · '.($flat->currentOwner ? trim($flat->currentOwner->first_name.' '.$flat->currentOwner->last_name) : 'Vacant'))->values()->all(),
                ],
                [
                    'title' => 'Pricing History',
                    'type' => 'list',
                    'rows' => $flatRecords->flatMap(fn ($flat) => $flat->pricingHistories)->filter()->map(fn ($history) => ($history->flat?->building_no ?? '').'-'.($history->flat?->flat_no ?? '').' · '.number_format($history->price ?? 0, 2).' · '.($history->effective_date ? $history->effective_date->format('M d, Y') : 'N/A'))->values()->all(),
                ],
                [
                    'title' => 'Income',
                    'type' => 'list',
                    'rows' => $incomeRecords->map(fn ($income) => ($income->invoice_no ?? 'Income '.$income->id).' · '.number_format($income->price ?? 0, 2).' · '.($income->client ? trim($income->client->first_name.' '.$income->client->last_name) : 'N/A'))->values()->all(),
                ],
                [
                    'title' => 'Expenses',
                    'type' => 'list',
                    'rows' => $expenseRecords->map(fn ($expense) => ($expense->transaction_reference ?? 'Expense '.$expense->id).' · '.number_format($expense->amount ?? 0, 2).' · '.($expense->expenseType->name ?? 'N/A'))->values()->all(),
                ],
            ],
        ];
    }

    protected function buildClientDetailReport(int $clientId): ?array
    {
        $client = Client::with(['flats.project', 'incomes.project', 'incomes.paymentMethod'])->find($clientId);

        if (! $client) {
            return null;
        }

        $flatRecords = $client->flats()->with('project')->get();
        $incomeRecords = $client->incomes()->with(['project', 'paymentMethod'])->get();
        $projectNames = $incomeRecords->pluck('project.name')->filter()->unique()->values()->all();

        return [
            'module' => 'clients',
            'records' => collect([$client]),
            'labels' => [trim($client->first_name.' '.$client->last_name)],
            'totals' => [
                'record_count' => 1,
                'flat_count' => $flatRecords->count(),
                'income_count' => $incomeRecords->count(),
                'income_total' => $incomeRecords->sum('price'),
            ],
            'grouped' => [],
            'item' => $client,
            'item_label' => trim($client->first_name.' '.$client->last_name),
            'title' => 'Client Profile Report',
            'sections' => [
                [
                    'title' => 'Overview',
                    'type' => 'summary',
                    'rows' => [
                        ['label' => 'Name', 'value' => trim($client->first_name.' '.$client->last_name)],
                        ['label' => 'Phone', 'value' => $client->phone ?? 'N/A'],
                        ['label' => 'Email', 'value' => $client->email ?? 'N/A'],
                        ['label' => 'Address', 'value' => $client->address ?? 'N/A'],
                    ],
                ],
                [
                    'title' => 'Flats',
                    'type' => 'list',
                    'rows' => $flatRecords->map(fn ($flat) => ($flat->building_no ?? '').'-'.($flat->flat_no ?? '').' · '.($flat->project->name ?? 'N/A'))->values()->all(),
                ],
                [
                    'title' => 'Income',
                    'type' => 'list',
                    'rows' => $incomeRecords->map(fn ($income) => ($income->invoice_no ?? 'Income '.$income->id).' · '.number_format($income->price ?? 0, 2).' · '.($income->project->name ?? 'N/A'))->values()->all(),
                ],
                [
                    'title' => 'Projects',
                    'type' => 'list',
                    'rows' => $projectNames ?: ['No project activity recorded'],
                ],
            ],
        ];
    }

    protected function buildFlatDetailReport(int $flatId): ?array
    {
        $flat = Flat::with(['project', 'currentOwner', 'pricingHistories', 'incomes.client', 'incomes.paymentMethod', 'expenses.expenseType', 'expenses.paymentMethod'])->find($flatId);

        if (! $flat) {
            return null;
        }

        $incomeRecords = $flat->incomes()->with(['client', 'paymentMethod'])->get();
        $expenseRecords = $flat->expenses()->with(['expenseType', 'paymentMethod'])->get();

        return [
            'module' => 'flats',
            'records' => collect([$flat]),
            'labels' => [($flat->building_no ?? '').'-'.($flat->flat_no ?? '')],
            'totals' => [
                'record_count' => 1,
                'income_count' => $incomeRecords->count(),
                'expense_count' => $expenseRecords->count(),
                'income_total' => $incomeRecords->sum('price'),
                'expense_total' => $expenseRecords->sum('amount'),
            ],
            'grouped' => [],
            'item' => $flat,
            'item_label' => ($flat->building_no ?? '').'-'.($flat->flat_no ?? ''),
            'title' => 'Flat Detail Report',
            'sections' => [
                [
                    'title' => 'Overview',
                    'type' => 'summary',
                    'rows' => [
                        ['label' => 'Flat', 'value' => ($flat->building_no ?? '').'-'.($flat->flat_no ?? '')],
                        ['label' => 'Project', 'value' => $flat->project->name ?? 'N/A'],
                        ['label' => 'Owner', 'value' => $flat->currentOwner ? trim($flat->currentOwner->first_name.' '.$flat->currentOwner->last_name) : 'Vacant'],
                        ['label' => 'Status', 'value' => $flat->client_owner_status ?? 'N/A'],
                    ],
                ],
                [
                    'title' => 'Pricing History',
                    'type' => 'list',
                    'rows' => $flat->pricingHistories->map(fn ($history) => number_format($history->price ?? 0, 2).' · '.($history->effective_date ? $history->effective_date->format('M d, Y') : 'N/A'))->values()->all(),
                ],
                [
                    'title' => 'Income',
                    'type' => 'list',
                    'rows' => $incomeRecords->map(fn ($income) => ($income->invoice_no ?? 'Income '.$income->id).' · '.number_format($income->price ?? 0, 2))->values()->all(),
                ],
                [
                    'title' => 'Expenses',
                    'type' => 'list',
                    'rows' => $expenseRecords->map(fn ($expense) => ($expense->transaction_reference ?? 'Expense '.$expense->id).' · '.number_format($expense->amount ?? 0, 2))->values()->all(),
                ],
            ],
        ];
    }

    protected function buildIncomeDetailReport(int $incomeId): ?array
    {
        $income = Income::with(['project', 'flat', 'client', 'paymentMethod'])->find($incomeId);

        if (! $income) {
            return null;
        }

        return [
            'module' => 'incomes',
            'records' => collect([$income]),
            'labels' => [$income->invoice_no ?: 'Income '.$income->id],
            'totals' => [
                'record_count' => 1,
                'amount' => $income->price ?? 0,
            ],
            'grouped' => [],
            'item' => $income,
            'item_label' => $income->invoice_no ?: 'Income '.$income->id,
            'title' => 'Income Detail Report',
            'sections' => [
                [
                    'title' => 'Overview',
                    'type' => 'summary',
                    'rows' => [
                        ['label' => 'Invoice', 'value' => $income->invoice_no ?: 'Income '.$income->id],
                        ['label' => 'Amount', 'value' => number_format($income->price ?? 0, 2)],
                        ['label' => 'Status', 'value' => $income->clearing_status ?? 'N/A'],
                        ['label' => 'Client', 'value' => $income->client ? trim($income->client->first_name.' '.$income->client->last_name) : 'N/A'],
                    ],
                ],
                [
                    'title' => 'Related Records',
                    'type' => 'list',
                    'rows' => [
                        'Project: '.($income->project->name ?? 'N/A'),
                        'Flat: '.($income->flat ? ($income->flat->building_no ?? '').'-'.($income->flat->flat_no ?? '') : 'N/A'),
                        'Payment Method: '.($income->paymentMethod->name ?? 'N/A'),
                    ],
                ],
            ],
        ];
    }

    protected function buildExpenseDetailReport(int $expenseId): ?array
    {
        $expense = Expense::with(['project', 'flat', 'expenseType', 'paymentMethod'])->find($expenseId);

        if (! $expense) {
            return null;
        }

        return [
            'module' => 'expenses',
            'records' => collect([$expense]),
            'labels' => [$expense->transaction_reference ?: 'Expense '.$expense->id],
            'totals' => [
                'record_count' => 1,
                'amount' => $expense->amount ?? 0,
            ],
            'grouped' => [],
            'item' => $expense,
            'item_label' => $expense->transaction_reference ?: 'Expense '.$expense->id,
            'title' => 'Expense Detail Report',
            'sections' => [
                [
                    'title' => 'Overview',
                    'type' => 'summary',
                    'rows' => [
                        ['label' => 'Reference', 'value' => $expense->transaction_reference ?: 'Expense '.$expense->id],
                        ['label' => 'Amount', 'value' => number_format($expense->amount ?? 0, 2)],
                        ['label' => 'Status', 'value' => $expense->payment_status ?? 'N/A'],
                        ['label' => 'Category', 'value' => $expense->expenseType->name ?? 'N/A'],
                    ],
                ],
                [
                    'title' => 'Related Records',
                    'type' => 'list',
                    'rows' => [
                        'Project: '.($expense->project->name ?? 'N/A'),
                        'Flat: '.($expense->flat ? ($expense->flat->building_no ?? '').'-'.($expense->flat->flat_no ?? '') : 'N/A'),
                        'Payment Method: '.($expense->paymentMethod->name ?? 'N/A'),
                    ],
                ],
            ],
        ];
    }

    protected function applyDateFilter($query, Request $request, string $module)
    {
        $from = $request->input('from_date');
        $to = $request->input('to_date');

        if ($from) {
            $column = $module === 'incomes' ? 'created_at' : ($module === 'expenses' ? 'date' : 'created_at');
            $query->whereDate($column, '>=', $from);
        }

        if ($to) {
            $column = $module === 'incomes' ? 'created_at' : ($module === 'expenses' ? 'date' : 'created_at');
            $query->whereDate($column, '<=', $to);
        }

        return $query;
    }

    protected function applyItemFilter($query, Request $request, string $module)
    {
        $itemId = $request->input('item_id');

        if (! $itemId) {
            return $query;
        }

        return match ($module) {
            'projects' => $query->where('id', $itemId),
            'clients' => $query->where('id', $itemId),
            'flats' => $query->where('id', $itemId),
            'incomes' => $query->where(function ($subQuery) use ($itemId) {
                $subQuery->where('project_id', $itemId)
                    ->orWhere('flat_id', $itemId)
                    ->orWhere('client_id', $itemId);
            }),
            'expenses' => $query->where(function ($subQuery) use ($itemId) {
                $subQuery->where('project_id', $itemId)
                    ->orWhere('flat_id', $itemId)
                    ->orWhere('expense_type_id', $itemId);
            }),
            default => $query,
        };
    }

    protected function applyStatusFilter($query, Request $request, string $module)
    {
        $status = $request->input('status');

        if (! $status) {
            return $query;
        }

        return match ($module) {
            'projects' => $query->where('status', $status),
            'clients' => $query,
            'flats' => $query->where('client_owner_status', $status),
            'incomes' => $query->where('clearing_status', $status),
            'expenses' => $query->where('payment_status', $status),
            default => $query,
        };
    }

    protected function groupRecords($records, ?string $groupBy): array
    {
        if (! $groupBy || $records->isEmpty()) {
            return [];
        }

        return $records->groupBy(function ($record) use ($groupBy) {
            return match ($groupBy) {
                'project' => $record->project?->name ?? 'Unassigned',
                'status' => $record->status ?? $record->payment_status ?? $record->clearing_status ?? 'N/A',
                'month' => $record->created_at?->format('M Y') ?? $record->date?->format('M Y') ?? 'N/A',
                default => 'All',
            };
        })->map(function ($group) {
            return [
                'count' => $group->count(),
                'total' => $group->sum(fn ($item) => (float) ($item->price ?? $item->amount ?? 0)),
            ];
        })->toArray();
    }

    protected function labelsFor(string $module, $records): array
    {
        return match ($module) {
            'projects' => $records->map(fn ($record) => $record->name)->all(),
            'clients' => $records->map(fn ($record) => trim($record->first_name.' '.$record->last_name))->all(),
            'flats' => $records->map(fn ($record) => $record->building_no.'-'.$record->flat_no)->all(),
            'incomes' => $records->map(fn ($record) => $record->invoice_no ?: 'Income '.$record->id)->all(),
            'expenses' => $records->map(fn ($record) => $record->transaction_reference ?: 'Expense '.$record->id)->all(),
            default => [],
        };
    }

    protected function totalsFor(string $module, $records): array
    {
        return match ($module) {
            'projects' => ['count' => $records->count()],
            'clients' => ['count' => $records->count()],
            'flats' => ['count' => $records->count()],
            'incomes' => ['count' => $records->count(), 'total' => $records->sum('price')],
            'expenses' => ['count' => $records->count(), 'total' => $records->sum('amount')],
            default => ['count' => $records->count()],
        };
    }

    protected function moduleOptions(): array
    {
        return [
            ['value' => 'projects', 'label' => 'Projects'],
            ['value' => 'clients', 'label' => 'Clients'],
            ['value' => 'flats', 'label' => 'Flats'],
            ['value' => 'incomes', 'label' => 'Incomes'],
            ['value' => 'expenses', 'label' => 'Expenses'],
        ];
    }
}
