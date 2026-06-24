<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortalBalanceStoreRequest;
use App\Http\Requests\PortalBalanceUpdateRequest;
use App\Models\Info;
use App\Models\Portal;
use App\Models\PortalBalance;

class PortalBalanceController extends Controller
{
    public function index()
    {
        $query = PortalBalance::query();

        // Date range filtering: accept `date_range` or single `date` for backward compatibility
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
        } elseif ($date = request('date')) {
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

        if ($portal = request('portal')) {
            $query->where('portal', 'like', "%{$portal}%");
        }

        if (null !== ($min = request('min_recharge')) && $min !== '') {
            if (is_numeric($min)) {
                $query->where('recharge', '>=', $min);
            }
        }

        if (null !== ($max = request('max_recharge')) && $max !== '') {
            if (is_numeric($max)) {
                $query->where('recharge', '<=', $max);
            }
        }

        // Compute summary totals for filtered or all portal balances
        $summary = (clone $query)
            ->selectRaw("
                COUNT(*) as total_count, 
                COALESCE(SUM(CASE WHEN transaction_type = 'credit' THEN recharge ELSE 0 END), 0) as total_recharge, 
                COALESCE(AVG(CASE WHEN transaction_type = 'credit' THEN recharge ELSE NULL END), 0) as avg_recharge, 
                COALESCE(SUM(CASE WHEN transaction_type = 'credit' THEN 1 ELSE 0 END), 0) as recharge_count
            ")
            ->first();

        // pagination size control
        $perPageInput = request('per_page');
        $defaultPerPage = 25;
        if ($perPageInput === 'all') {
            $items = $query->latest()->get();
        } else {
            $perPage = is_numeric($perPageInput) ? (int) $perPageInput : $defaultPerPage;
            $allowed = [$defaultPerPage, 100, 500, 1000, 5000];
            if (! in_array($perPage, $allowed)) {
                $perPage = $defaultPerPage;
            }
            $items = $query->latest()->paginate($perPage)->withQueryString();
        }

        $itemsTotal = method_exists($items, 'total') ? $items->total() : $items->count();

        // Load dropdown lists for advanced search
        $portals = Portal::orderBy('name')->get();

        // Compute per-portal balances for the summary (respecting date range)
        $portalBalances = Portal::orderBy('name')->get()->map(function ($p) use ($start, $end) {
            $q = PortalBalance::query();

            if ($start && $end) {
                $q->whereBetween('date', [$start->toDateString(), $end->toDateString()]);
            }

            // Match by ID or Name
            $q->where(function ($qq) use ($p) {
                $qq->where('portal', $p->id)->orWhere('portal', $p->name);
            });

            /**
             * total_recharge: Sum of all 'credit' transactions
             * total_sales: Sum of all 'debit' transactions
             */
            $row = $q->selectRaw("
        SUM(CASE WHEN transaction_type = 'credit' THEN COALESCE(recharge, 0) ELSE 0 END) as total_recharge,
        SUM(CASE WHEN transaction_type = 'debit' THEN COALESCE(recharge, 0) ELSE 0 END) as total_sales
    ")->first();

            $totalRecharge = (float) ($row->total_recharge ?? 0);
            $totalSales = (float) ($row->total_sales ?? 0);

            // Balance calculation
            $current = $totalRecharge - $totalSales;

            return (object) [
                'label' => $p->name,
                'balance' => $totalRecharge, // All money added
                'sales' => $totalSales,    // All money spent/sales
                'current' => $current,      // Remaining amount
            ];
        });

        return view('portal_balances.index', ['items' => $items, 'summary' => $summary, 'start' => $start, 'end' => $end, 'portals' => $portals, 'portalBalances' => $portalBalances, 'itemsTotal' => $itemsTotal]);
    }

    public function create()
    {
        $portals = Portal::all();
        $infos = Info::all();

        return view('portal_balances.create', compact('portals', 'infos'));
    }

    public function store(PortalBalanceStoreRequest $request)
    {
        $data = $request->validated();
        PortalBalance::create($data);

        return redirect()->route('portal-balances.index')->with('success', 'Portal transaction recorded');
    }

    public function show(PortalBalance $portal_balance)
    {
        return view('portal_balances.show', ['item' => $portal_balance]);
    }

    public function update(PortalBalanceUpdateRequest $request, PortalBalance $portal_balance)
    {
        $data = $request->validated();
        $portal_balance->update($data);

        return redirect()->route('portal-balances.index')->with('success', 'Portal transaction updated');
    }

    public function edit(PortalBalance $portal_balance)
    {
        $portals = Portal::all();
        $infos = Info::all();

        return view('portal_balances.edit', ['item' => $portal_balance, 'portals' => $portals, 'infos' => $infos]);
    }
}
