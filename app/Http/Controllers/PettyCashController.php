<?php

namespace App\Http\Controllers;

use App\Http\Requests\PettyCashStoreRequest;
use App\Http\Requests\PettyCashUpdateRequest;
use App\Models\Expense;
use App\Models\PettyCash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PettyCashController extends Controller
{
    public function index(Request $request)
    {
        // Allow filtering for trashed records
        if ($request->query('only_trashed')) {
            $query = PettyCash::onlyTrashed();
        } elseif ($request->query('with_trashed')) {
            $query = PettyCash::withTrashed();
        } else {
            $query = PettyCash::query();
        }

        // basic text filter
        if ($v = $request->query('title')) {
            $query->where('title', 'like', "%{$v}%");
        }

        // date range filtering (date)
        $start = null;
        $end = null;
        $rangeInput = $request->query('date_range');
        if ($rangeInput) {
            $r = trim($rangeInput);
            if (preg_match('/\d{4}-\d{2}-\d{2}\s*-\s*\d{4}-\d{2}-\d{2}/', $r) || preg_match('/\d{1,2}\/\d{1,2}\/\d{4}\s*-\s*\d{1,2}\/\d{1,2}\/\d{4}/', $r)) {
                $parts = preg_split('/\s*-\s*/', $r, 2);
                if (count($parts) === 2) {
                    try {
                        $a = \Carbon\Carbon::parse($parts[0]);
                        $b = \Carbon\Carbon::parse($parts[1]);
                        $start = $a->copy()->startOfDay();
                        $end = $b->copy()->endOfDay();
                    } catch (\Exception $e) {
                        $start = null;
                        $end = null;
                    }
                }
            }
        } elseif ($date = $request->query('date')) {
            try {
                $d = \Carbon\Carbon::parse($date);
                $start = $d->copy()->startOfDay();
                $end = $d->copy()->endOfDay();
            } catch (\Exception $e) {
                $start = null;
                $end = null;
            }
        }

        if ($start && $end) {
            $query->whereBetween('date', [$start->toDateString(), $end->toDateString()]);
        }

        // numeric range filters
        if (null !== ($min = $request->query('min_amount')) && $min !== '') {
            if (is_numeric($min)) {
                $query->where('amount', '>=', $min);
            }
        }

        if (null !== ($max = $request->query('max_amount')) && $max !== '') {
            if (is_numeric($max)) {
                $query->where('amount', '<=', $max);
            }
        }

        // Prepare summary data based on current filters
        $summaryQuery = clone $query;
        $summary = (object) [
            'total_count' => $summaryQuery->count(),
            'total_amount' => (float) $summaryQuery->sum('amount'),
            'avg_amount' => $summaryQuery->count() ? (float) $summaryQuery->sum('amount') / $summaryQuery->count() : 0,
        ];

        // pagination size control
        $perPageInput = $request->query('per_page');
        $defaultPerPage = 25;
        if ($perPageInput === 'all') {
            $pettyCashes = $query->orderBy('created_at', 'desc')->get();
        } else {
            $perPage = is_numeric($perPageInput) ? (int) $perPageInput : $defaultPerPage;
            $allowed = [$defaultPerPage, 100, 500, 1000, 5000];
            if (! in_array($perPage, $allowed)) {
                $perPage = $defaultPerPage;
            }
            $pettyCashes = $query->orderBy('created_at', 'desc')->paginate($perPage)->appends($request->query());
        }

        $pettyCashesTotal = method_exists($pettyCashes, 'total') ? $pettyCashes->total() : $pettyCashes->count();

        // Totals respecting current filters (date range etc.)
        $totalAdded = (float) $summaryQuery->where('transaction_type', 'credit_manual')->sum('amount');

        $usedQuery = PettyCash::query()->where('transaction_type', 'debit_expense');
        if ($start && $end) {
            $usedQuery->whereBetween('date', [$start->toDateString(), $end->toDateString()]);
        }
        $totalUsed = (float) $usedQuery->sum('amount');

        $pettyBalance = round($totalAdded - $totalUsed, 2);

        return view('petty_cashes.index', compact('pettyCashes', 'pettyBalance', 'totalAdded', 'totalUsed', 'summary', 'pettyCashesTotal', 'start', 'end'));
    }

    public function create(PettyCash $pettyCash)
    {
        $expenses = Expense::orderBy('transaction_reference')->get();

        return view('petty_cashes.create', compact('pettyCash', 'expenses'));
    }

    public function store(PettyCashStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        PettyCash::create($data);

        return redirect()->route('petty-cashes.index')->with('success', 'Petty cash added successfully.');
    }

    public function show(PettyCash $pettyCash)
    {
        return view('petty_cashes.show', compact('pettyCash'));
    }

    public function edit(PettyCash $pettyCash)
    {
        $expenses = Expense::orderBy('transaction_reference')->get();

        return view('petty_cashes.edit', compact('pettyCash', 'expenses'));
    }

    public function update(PettyCashUpdateRequest $request, PettyCash $pettyCash)
    {
        $data = $request->validated();
        $pettyCash->update($data);

        return redirect()->route('petty-cashes.index')->with('success', 'Petty cash updated successfully.');
    }

    public function destroy(PettyCash $pettyCash)
    {
        $pettyCash->delete();

        return redirect()->route('petty-cashes.index')->with('success', 'Petty cash deleted successfully.');
    }
}
