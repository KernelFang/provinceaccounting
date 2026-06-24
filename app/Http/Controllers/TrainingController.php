<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainingStoreRequest;
use App\Http\Requests\TrainingUpdateRequest;
use App\Models\Training;
use App\Models\TrainingType;

class TrainingController extends Controller
{
    public function index()
    {
        $query = Training::query();

        // Date range filtering: accept `date_range` or single `purchase_date` for backward compatibility
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
                        $start = null;
                        $end = null;
                    }
                }
            }
        } elseif ($purchaseDate = request('purchase_date')) {
            try {
                $d = \Carbon\Carbon::parse($purchaseDate);
                $start = $d->copy()->startOfDay();
                $end = $d->copy()->endOfDay();
            } catch (\Exception $e) {
                $start = null;
                $end = null;
            }
        }

        if ($start && $end) {
            $query->whereBetween('purchase_date', [$start->toDateString(), $end->toDateString()]);
        }

        if ($type = request('training_type')) {
            $query->where('training_type', 'like', "%{$type}%");
        }

        if ($title = request('title')) {
            $query->where('title', 'like', "%{$title}%");
        }

        if ($min = request('min_price')) {
            $query->where('customer_price', '>=', (float) $min);
        }

        if ($customer = request('customer_name')) {
            $query->where('customer_name', 'like', "%{$customer}%");
        }

        if ($customerNumber = request('customer_number')) {
            $query->where('customer_number', 'like', "%{$customerNumber}%");
        }

        if (request()->filled('has_due')) {
            $query->where('customer_due', '>', 0);
        }

        $summaryRow = (clone $query)
            ->selectRaw('COUNT(*) as total_count, COALESCE(SUM(customer_price),0) as total_price, COALESCE(SUM(customer_payment),0) as total_paid, COALESCE(SUM(customer_due),0) as total_due, COALESCE(AVG(customer_price),0) as avg_price')
            ->first();

        $summary = (object) [
            'total_count' => $summaryRow->total_count ?? 0,
            'total_price' => $summaryRow->total_price ?? 0,
            'total_paid' => $summaryRow->total_paid ?? 0,
            'total_due' => $summaryRow->total_due ?? 0,
            'avg_price' => $summaryRow->avg_price ?? 0,
        ];

        // pagination size control
        $perPageInput = request('per_page');
        $defaultPerPage = 25;
        if ($perPageInput === 'all') {
            $trainings = $query->latest()->get();
        } else {
            $perPage = is_numeric($perPageInput) ? (int) $perPageInput : $defaultPerPage;
            $allowed = [$defaultPerPage, 100, 500, 1000, 5000];
            if (! in_array($perPage, $allowed)) {
                $perPage = $defaultPerPage;
            }
            $trainings = $query->latest()->paginate($perPage)->withQueryString();
        }

        $trainingsTotal = method_exists($trainings, 'total') ? $trainings->total() : $trainings->count();

        $trainingTypes = TrainingType::orderBy('name')->get();

        return view('trainings.index', compact('trainings', 'summary', 'start', 'end', 'trainingTypes', 'trainingsTotal'));
    }

    public function create()
    {
        $trainingTypes = TrainingType::orderBy('name')->get();

        return view('trainings.create', compact('trainingTypes'));
    }

    public function store(TrainingStoreRequest $request)
    {
        $data = $request->validated();

        // compute customer due (customer_fare - customer_payment)
        $price = isset($data['customer_price']) ? (float) $data['customer_price'] : 0.0;
        $paid = isset($data['customer_payment']) ? (float) $data['customer_payment'] : 0.0;
        $data['customer_due'] = $price - $paid;

        // compute profit (customer_fare - agent_fare)
        $agentCost = isset($data['agent_cost']) ? (float) $data['agent_cost'] : 0.0;
        $data['profit'] = $price - $agentCost;

        Training::create($data);

        return redirect()->route('trainings.index')->with('success', 'Training created');
    }

    public function show(Training $training)
    {
        return view('trainings.show', compact('training'));
    }

    public function edit(Training $training)
    {
        $trainingTypes = TrainingType::orderBy('name')->get();

        return view('trainings.edit', compact('training', 'trainingTypes'));
    }

    public function update(TrainingUpdateRequest $request, Training $training)
    {
        $data = $request->validated();

        // compute customer due (customer_fare - customer_payment)
        $price = isset($data['customer_price']) ? (float) $data['customer_price'] : 0.0;
        $paid = isset($data['customer_payment']) ? (float) $data['customer_payment'] : 0.0;
        $data['customer_due'] = $price - $paid;

        // compute profit (customer_fare - agent_fare)
        $agentCost = isset($data['agent_cost']) ? (float) $data['agent_cost'] : 0.0;
        $data['profit'] = $price - $agentCost;

        $training->update($data);

        return redirect()->route('trainings.index')->with('success', 'Training updated');
    }

    public function destroy(Training $training)
    {
        $training->delete();

        return redirect()->route('trainings.index')->with('success', 'Removed');
    }
}
