<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeStoreRequest;
use App\Http\Requests\IncomeUpdateRequest;
use App\Models\Client;
use App\Models\Flat;
use App\Models\Income;
use App\Models\PaymentMethod;
use App\Models\Project;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Income::with(['project', 'flat', 'client', 'paymentMethod']);

        if ($projectId = $request->query('project_id')) {
            $query->where('project_id', $projectId);
        }

        if ($flatId = $request->query('flat_id')) {
            $query->where('flat_id', $flatId);
        }

        if ($clientId = $request->query('client_id')) {
            $query->where('client_id', $clientId);
        }

        if ($status = $request->query('clearing_status')) {
            $query->where('clearing_status', $status);
        }

        $incomes = $query->latest()->paginate(25)->appends($request->query());
        $projects = Project::orderBy('name')->get();
        $flats = Flat::orderBy('flat_no')->get();
        $clients = Client::orderBy('first_name')->get();
        $paymentMethods = PaymentMethod::orderBy('name')->get();

        return view('incomes.index', compact('incomes', 'projects', 'flats', 'clients', 'paymentMethods'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();
        $flats = Flat::orderBy('flat_no')->get();
        $clients = Client::orderBy('first_name')->get();
        $paymentMethods = PaymentMethod::orderBy('name')->get();

        return view('incomes.create', compact('projects', 'flats', 'clients', 'paymentMethods'));
    }

    public function store(IncomeStoreRequest $request)
    {
        Income::create($request->validated());

        return redirect()->route('incomes.index')->with('success', 'Income recorded successfully.');
    }

    public function show(Income $income)
    {
        return view('incomes.show', compact('income'));
    }

    public function edit(Income $income)
    {
        $projects = Project::orderBy('name')->get();
        $flats = Flat::orderBy('flat_no')->get();
        $clients = Client::orderBy('first_name')->get();
        $paymentMethods = PaymentMethod::orderBy('name')->get();

        return view('incomes.edit', compact('income', 'projects', 'flats', 'clients', 'paymentMethods'));
    }

    public function update(IncomeUpdateRequest $request, Income $income)
    {
        $income->update($request->validated());

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');
    }
}
