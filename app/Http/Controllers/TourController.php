<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Http\Requests\TourStoreRequest;
use App\Http\Requests\TourUpdateRequest;
use App\Models\Purpose;
use App\Models\Country;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index()
    {
        $query = Tour::query();

        // Date range filtering: accept `date_range` or single date params
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
        } elseif ($date = request('from_date')) {
            try {
                $d = \Carbon\Carbon::parse($date);
                $start = $d->copy()->startOfDay();
                $end = $d->copy()->endOfDay();
            } catch (\Exception $e) {
                $start = null; $end = null;
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
                . 'COALESCE(SUM(customer_price),0) as total_price, '
                . 'COALESCE(SUM(profit),0) as total_profit, '
                . 'COALESCE(SUM(customer_payment),0) as total_paid, '
                . 'COALESCE(SUM(customer_price - COALESCE(customer_payment,0)),0) as total_due, '
                . 'COALESCE(AVG(customer_price),0) as avg_price'
            )
            ->first();

        // pagination size control
        $perPageInput = request('per_page');
        $defaultPerPage = 25;
        if ($perPageInput === 'all') {
            $tours = $query->latest()->get();
        } else {
            $perPage = is_numeric($perPageInput) ? (int) $perPageInput : $defaultPerPage;
            $allowed = [$defaultPerPage, 100, 500, 1000, 5000];
            if (! in_array($perPage, $allowed)) {
                $perPage = $defaultPerPage;
            }
            $tours = $query->latest()->paginate($perPage)->withQueryString();
        }

        $toursTotal = method_exists($tours, 'total') ? $tours->total() : $tours->count();

        $purposes = Purpose::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();

        return view('tours.index', compact('tours', 'summary', 'start', 'end', 'purposes', 'countries', 'toursTotal'));
    }

    public function create()
    {
        $purposes = Purpose::all();
        $countries = Country::all();
        return view('tours.create', compact('purposes','countries'));
    }

    public function store(TourStoreRequest $request)
    {
        $data = $request->validated();

        // compute customer due (customer_fare - customer_payment)
        $price = isset($data['customer_price']) ? (float) $data['customer_price'] : 0.0;
        $paid = isset($data['customer_payment']) ? (float) $data['customer_payment'] : 0.0;
        $data['customer_due'] = $price - $paid;

        // compute profit (customer_fare - agent_fare)
        $agentCost = isset($data['agent_cost']) ? (float) $data['agent_cost'] : 0.0;
        $data['profit'] = $price - $agentCost;

        Tour::create($data);
        return redirect()->route('tours.index')->with('success', 'Tour created');
    }

    public function show(Tour $tour)
    {
        return view('tours.show', compact('tour'));
    }

    public function update(TourUpdateRequest $request, Tour $tour)
    {
        $data = $request->validated();
        
        // compute customer due (customer_fare - customer_payment)
        $price = isset($data['customer_price']) ? (float) $data['customer_price'] : 0.0;
        $paid = isset($data['customer_payment']) ? (float) $data['customer_payment'] : 0.0;
        $data['customer_due'] = $price - $paid;

        // compute profit (customer_fare - agent_fare)
        $agentCost = isset($data['agent_cost']) ? (float) $data['agent_cost'] : 0.0;
        $data['profit'] = $price - $agentCost;

        $tour->update($data);
        return redirect()->route('tours.index')->with('success', 'Tour updated');
    }

    public function edit(Tour $tour)
    {
        $purposes = Purpose::all();
        $countries = Country::all();
        return view('tours.edit', compact('tour','purposes','countries'));
    }
}
