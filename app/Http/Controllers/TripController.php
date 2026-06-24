<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $items = Trip::latest()->paginate(50);
        return view('trips.index', compact('items'));
    }

    public function create()
    {
        return view('trips.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        Trip::create($data);
        return redirect()->route('trips.index')->with('success', 'Trip created');
    }

    public function edit(Trip $trip)
    {
        return view('trips.edit', ['item' => $trip]);
    }

    public function update(Request $request, Trip $trip)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        $trip->update($data);
        return redirect()->route('trips.index')->with('success', 'Trip updated');
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('trips.index')->with('success', 'Removed');
    }
}
