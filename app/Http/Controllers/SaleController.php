<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\Models\Airline;
use App\Models\FlightType;
use App\Models\Portal;
use App\Models\Sale;
use App\Models\ServiceType;
use App\Models\Trip;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    public function index()
    {
        $query = Sale::query();

        // Pagination size control
        $perPageInput = request('per_page');
        $defaultPerPage = 25;

        // Date range filtering: accept `date_range` (preferred) or single `issue_date` for backwards compatibility
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
        } elseif ($date = request('issue_date')) {
            // backwards compatibility: single date
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
            $query->whereBetween('issue_date', [$start->toDateString(), $end->toDateString()]);
        }

        if ($portal = request('portal')) {
            $query->where('issued_portal', 'like', "%{$portal}%");
        }

        if ($service = request('service_type')) {
            $query->where('service_type', 'like', "%{$service}%");
        }

        if ($airlinePnr = request('airline_pnr')) {
            $query->where('airline_pnr', 'like', "%{$airlinePnr}%");
        }

        if ($customerName = request('customer_name')) {
            $query->where('customer_name', 'like', "%{$customerName}%");
        }

        if ($customerPhone = request('customer_phone')) {
            $query->where(function ($q) use ($customerPhone) {
                $q->where('customer_phone', 'like', "%{$customerPhone}%")
                    ->orWhere('contact_no', 'like', "%{$customerPhone}%");
            });
        }

        if (null !== ($min = request('min_fare')) && $min !== '') {
            if (is_numeric($min)) {
                $query->where('customer_fare', '>=', $min);
            }
        }

        if (request()->filled('has_due')) {
            $query->where('customer_due', '>', 0);
        }

        $summary = (clone $query)
            ->selectRaw(
                'COUNT(*) as total_count, '
                .'COALESCE(SUM(customer_fare),0) as total_fare, '
                .'COALESCE(SUM(agent_fare),0) as total_agent_fare, '
                .'COALESCE(SUM(segment_fare),0) as total_segment_fare, '
                .'COALESCE(SUM(profit),0) as total_profit, '
                .'COALESCE(SUM(profit + COALESCE(segment_fare, 0)), 0) as net_profit, '
                .'COALESCE(SUM(customer_payment),0) as total_paid, '
                .'COALESCE(SUM(customer_fare - COALESCE(customer_payment,0)),0) as total_due'
            )
            ->first();

        if ($perPageInput === 'all') {
            $sales = $query->latest()->get(); // get all records
        } else {
            $perPage = is_numeric($perPageInput) ? (int) $perPageInput : $defaultPerPage;

            // Prevent extremely large unintended values
            $allowed = [$defaultPerPage, 100, 500, 1000, 5000];
            if (! in_array($perPage, $allowed)) {
                $perPage = $defaultPerPage;
            }

            $sales = $query->latest()->paginate($perPage)->withQueryString();
        }

        $salesTotal = method_exists($sales, 'total') ? $sales->total() : $sales->count();

        $portals = Portal::orderBy('name')->get();
        $service_types = ServiceType::orderBy('name')->get();

        return view('sales.index', compact('sales', 'summary', 'start', 'end', 'portals', 'service_types', 'salesTotal'));
    }

    public function create()
    {
        $portals = Portal::all();
        $service_types = ServiceType::all();
        $airlines = Airline::all();
        $flight_types = FlightType::all();
        $trips = Trip::all();

        return view('sales.create', compact('portals', 'service_types', 'airlines', 'flight_types', 'trips'));
    }

    public function store(SaleStoreRequest $request)
    {
        $data = $request->validated();

        // handle uploaded files: store and replace file objects with stored paths
        foreach (['images', 'videos', 'documents'] as $key) {
            if ($request->hasFile($key)) {
                $paths = [];
                foreach ($request->file($key) as $file) {
                    $paths[] = $file->store('sales/'.$key, 'public');
                }
                $data[$key] = $paths;
            }
        }

        // links: accept textarea string (one per line) and convert to array
        if ($request->filled('links')) {
            $lines = preg_split('/\r\n|\n|\r/', $request->input('links')) ?: [];
            $data['links'] = array_values(array_filter(array_map('trim', $lines)));
        }

        // compute customer due (customer_fare - customer_payment)
        $fare = isset($data['customer_fare']) ? (float) $data['customer_fare'] : 0.0;
        $paid = isset($data['customer_payment']) ? (float) $data['customer_payment'] : 0.0;
        $data['customer_due'] = $fare - $paid;

        // compute profit (customer_fare - agent_fare)
        $agentFare = isset($data['agent_fare']) ? (float) $data['agent_fare'] : 0.0;
        $data['profit'] = $fare - $agentFare;

        // Merge any additional non-validated inputs if needed
        Sale::create($data + $request->except(array_keys($data)));

        return redirect()->route('sales.index')->with('success', 'Sale created');
    }

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $portals = Portal::all();
        $service_types = ServiceType::all();
        $airlines = Airline::all();
        $flight_types = FlightType::all();
        $trips = Trip::all();

        return view('sales.edit', compact('sale', 'portals', 'service_types', 'airlines', 'flight_types', 'trips'));
    }

    public function update(SaleUpdateRequest $request, Sale $sale)
    {
        $data = $request->validated();

        // handle uploaded files: if new files provided, delete old files and store new ones; else keep existing
        foreach (['images', 'videos', 'documents'] as $key) {
            if ($request->hasFile($key)) {
                // remove previous files for this key to save storage
                $existing = $sale->{$key} ?? [];
                if (is_array($existing)) {
                    foreach ($existing as $p) {
                        if ($p && Storage::disk('public')->exists($p)) {
                            Storage::disk('public')->delete($p);
                        }
                    }
                }

                $paths = [];
                foreach ($request->file($key) as $file) {
                    $paths[] = $file->store('sales/'.$key, 'public');
                }
                $data[$key] = $paths;
            } else {
                // ensure we don't overwrite existing attachments with null when not provided
                unset($data[$key]);
            }
        }

        if ($request->filled('links')) {
            $lines = preg_split('/\r\n|\n|\r/', $request->input('links')) ?: [];
            $data['links'] = array_values(array_filter(array_map('trim', $lines)));
        } else {
            unset($data['links']);
        }

        // compute customer due (customer_fare - customer_payment)
        $fare = isset($data['customer_fare']) ? (float) $data['customer_fare'] : 0.0;
        $paid = isset($data['customer_payment']) ? (float) $data['customer_payment'] : 0.0;
        $data['customer_due'] = $fare - $paid;

        // compute profit (customer_fare - agent_fare)
        $agentFare = isset($data['agent_fare']) ? (float) $data['agent_fare'] : 0.0;
        $data['profit'] = $fare - $agentFare;

        $sale->update($data + $request->except(array_keys($data)));

        return redirect()->route('sales.index')->with('success', 'Sale updated');
    }
}
