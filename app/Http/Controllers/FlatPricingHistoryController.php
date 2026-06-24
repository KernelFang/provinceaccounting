<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlatPricingHistoryStoreRequest;
use App\Models\Flat;
use App\Models\FlatPricingHistory;
use Illuminate\Http\Request;

class FlatPricingHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = FlatPricingHistory::with('flat');

        if ($flatId = $request->query('flat_id')) {
            $query->where('flat_id', $flatId);
        }

        if ($date = $request->query('effective_date')) {
            $query->whereDate('effective_date', $date);
        }

        $histories = $query->latest()->paginate(25)->appends($request->query());
        $flats = Flat::orderBy('flat_no')->get();

        return view('flat_pricing_histories.index', compact('histories', 'flats'));
    }

    public function create()
    {
        $flats = Flat::orderBy('flat_no')->get();

        return view('flat_pricing_histories.create', compact('flats'));
    }

    public function store(FlatPricingHistoryStoreRequest $request)
    {
        FlatPricingHistory::create($request->validated());

        return redirect()->route('flat-pricing-histories.index')->with('success', 'Pricing history added successfully.');
    }

    public function show(FlatPricingHistory $flatPricingHistory)
    {
        return view('flat_pricing_histories.show', compact('flatPricingHistory'));
    }

    public function destroy(FlatPricingHistory $flatPricingHistory)
    {
        $flatPricingHistory->delete();

        return redirect()->route('flat-pricing-histories.index')->with('success', 'Pricing history deleted successfully.');
    }
}
