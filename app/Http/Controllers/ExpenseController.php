<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;
use App\Models\Expense;
use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expense::query();

        if ($v = $request->query('title')) {
            $query->where('title', 'like', "%{$v}%");
        }

        if ($cat = $request->query('expense_type_id')) {
            $query->where('expense_type_id', $cat);
        }

        if ($min = $request->query('min_amount')) {
            $query->where('amount', '>=', $min);
        }

        if ($max = $request->query('max_amount')) {
            $query->where('amount', '<=', $max);
        }

            // Date range filtering for expenses (date)
            $start = null;
            $end = null;
            $rangeInput = request('date_range');
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
                            $start = null; $end = null;
                        }
                    }
                }
            } elseif ($date = request('date')) {
                try {
                    $d = \Carbon\Carbon::parse($date);
                    $start = $d->copy()->startOfDay();
                    $end = $d->copy()->endOfDay();
                } catch (\Exception $e) {
                    $start = null; $end = null;
                }
            }

            if ($start && $end) {
                $query->whereBetween('date', [$start->toDateString(), $end->toDateString()]);
            }

        // Prepare summary for current filters
        $summaryQuery = clone $query;
        $summary = (object) [
            'total_count' => $summaryQuery->count(),
            'total_amount' => (float) $summaryQuery->sum('amount'),
            'avg_amount' => $summaryQuery->count() ? (float) $summaryQuery->sum('amount') / $summaryQuery->count() : 0,
        ];

        // Payment status breakdown for the current filters
        $paidQuery = (clone $query)->where('payment_status', 'paid');
        $unpaidQuery = (clone $query)->where('payment_status', 'unpaid');
        $pettyQuery = (clone $query)->where('payment_status', 'petty_cash');

        $paymentBreakdown = (object) [
            'paid_count' => $paidQuery->count(),
            'paid_amount' => (float) $paidQuery->sum('amount'),
            'unpaid_count' => $unpaidQuery->count(),
            'unpaid_amount' => (float) $unpaidQuery->sum('amount'),
            'petty_count' => $pettyQuery->count(),
            'petty_amount' => (float) $pettyQuery->sum('amount'),
        ];

        // pagination size control
        $perPageInput = $request->query('per_page');
        $defaultPerPage = 25;
        if ($perPageInput === 'all') {
            $expenses = $query->orderBy('created_at', 'desc')->get();
        } else {
            $perPage = is_numeric($perPageInput) ? (int) $perPageInput : $defaultPerPage;
            $allowed = [$defaultPerPage, 100, 500, 1000, 5000];
            if (! in_array($perPage, $allowed)) {
                $perPage = $defaultPerPage;
            }
            $expenses = $query->orderBy('created_at', 'desc')->paginate($perPage)->appends($request->query());
        }

        $expensesTotal = method_exists($expenses, 'total') ? $expenses->total() : $expenses->count();

        // Load dropdown lists for advanced search
        $categories = ExpenseType::orderBy('name')->get();

        return view('expenses.index', compact('expenses', 'summary', 'paymentBreakdown', 'start', 'end', 'categories', 'expensesTotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Expense $expense)
    {
        $categories = ExpenseType::orderBy('name')->get();
        return view('expenses.create', compact('expense', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseStoreRequest $request)
    {
        $validatedData = $request->validated();

        Expense::create($validatedData);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $categories = ExpenseType::orderBy('name')->get();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseUpdateRequest $request, Expense $expense)
    {
        $validatedData = $request->validated();

        $expense->update($validatedData);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully');
    }
}
