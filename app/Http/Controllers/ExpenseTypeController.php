<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseTypeStoreRequest;
use App\Http\Requests\ExpenseTypeUpdateRequest;
use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function index()
    {
        $types = ExpenseType::latest()->paginate(25);
        return view('expense_types.index', compact('types'));
    }

    public function create()
    {
        return view('expense_types.create');
    }

    public function store(ExpenseTypeStoreRequest $request)
    {
        ExpenseType::create($request->validated());

        return redirect()->route('expense-types.index')->with('success', 'Expense type created successfully.');
    }

    public function edit(ExpenseType $expenseType)
    {
        return view('expense_types.edit', compact('expenseType'));
    }

    public function update(ExpenseTypeUpdateRequest $request, ExpenseType $expenseType)
    {
        $expenseType->update($request->validated());

        return redirect()->route('expense-types.index')->with('success', 'Expense type updated successfully.');
    }

    public function destroy(ExpenseType $expenseType)
    {
        $expenseType->delete();

        return redirect()->route('expense-types.index')->with('success', 'Expense type deleted successfully.');
    }
}
