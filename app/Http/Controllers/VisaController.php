<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisaStoreRequest;
use App\Http\Requests\VisaUpdateRequest;
use App\Models\Country;
use App\Models\Visa;
use App\Models\VisaPurpose;

class VisaController extends Controller
{
    public function index()
    {
        $query = Visa::query();

        // Date range filtering support
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
        } elseif ($date = request('from_date')) {
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
            $query->whereBetween('purchase_date', [$start->toDateString(), $end->toDateString()]);
        }

        if ($purpose = request('purpose')) {
            $query->where('purpose', 'like', "%{$purpose}%");
        }

        if ($country = request('country')) {
            $query->where('country', 'like', "%{$country}%");
        }

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        if ($customer = request('customer')) {
            $query->where('customer', 'like', "%{$customer}%");
        }

        if ($customerNumber = request('customer_number')) {
            $query->where(function ($q) use ($customerNumber) {
                $q->where('mobile_number', 'like', "%{$customerNumber}%")
                    ->orWhere('customer', 'like', "%{$customerNumber}%");
            });
        }

        if (null !== ($min = request('min_price')) && $min !== '') {
            if (is_numeric($min)) {
                $query->where('customer_price', '>=', $min);
            }
        }

        if (request()->filled('has_due')) {
            $query->where('customer_due', '>', 0);
        }

        $summary = (clone $query)
            ->selectRaw(
                'COUNT(*) as total_count, '
                .'COALESCE(SUM(customer_price),0) as total_price, '
                .'COALESCE(SUM(profit),0) as total_profit, '
                .'COALESCE(SUM(customer_payment),0) as total_paid, '
                .'COALESCE(SUM(customer_price - COALESCE(customer_payment,0)),0) as total_due, '
                .'COALESCE(AVG(customer_price),0) as avg_price'
            )
            ->first();

        // pagination size control (same options as other index pages)
        $perPageInput = request('per_page');
        $defaultPerPage = 25;
        if ($perPageInput === 'all') {
            $visas = $query->latest()->get();
        } else {
            $perPage = is_numeric($perPageInput) ? (int) $perPageInput : $defaultPerPage;
            $allowed = [$defaultPerPage, 100, 500, 1000, 5000];
            if (! in_array($perPage, $allowed)) {
                $perPage = $defaultPerPage;
            }
            $visas = $query->latest()->paginate($perPage)->withQueryString();
        }

        // helper for view when using "all"
        $visasTotal = method_exists($visas, 'total') ? $visas->total() : $visas->count();

        $purposes = VisaPurpose::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();

        return view('visas.index', compact('visas', 'summary', 'start', 'end', 'purposes', 'countries', 'visasTotal'));
    }

    public function create()
    {
        $purposes = VisaPurpose::orderBy('name')->get();
        $countries = Country::all();

        return view('visas.create', compact('purposes', 'countries'));
    }

    public function store(VisaStoreRequest $request)
    {
        $data = $request->validated();

        // compute customer due (customer_fare - customer_payment)
        $price = isset($data['customer_price']) ? (float) $data['customer_price'] : 0.0;
        $paid = isset($data['customer_payment']) ? (float) $data['customer_payment'] : 0.0;
        $data['customer_due'] = $price - $paid;

        // compute profit (customer_fare - agent_fare)
        $agentCost = isset($data['agent_cost']) ? (float) $data['agent_cost'] : 0.0;
        $data['profit'] = $price - $agentCost;

        Visa::create($data);

        return redirect()->route('visas.index')->with('success', 'Visa created');
    }

    public function show(Visa $visa)
    {
        return view('visas.show', compact('visa'));
    }

    public function edit(Visa $visa)
    {
        $purposes = VisaPurpose::orderBy('name')->get();
        $countries = Country::all();

        return view('visas.edit', compact('visa', 'purposes', 'countries'));
    }

    public function update(VisaUpdateRequest $request, Visa $visa)
    {
        $data = $request->validated();
        $visa->update($data);

        return redirect()->route('visas.index')->with('success', 'Visa updated');
    }
}
