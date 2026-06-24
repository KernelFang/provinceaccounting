<?php

namespace App\Http\Controllers;

use App\Models\FlightType;
use Illuminate\Http\Request;

class FlightTypeController extends Controller
{
    public function index()
    {
        $items = FlightType::latest()->paginate(50);
        return view('flight_types.index', compact('items'));
    }

    public function create()
    {
        return view('flight_types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        FlightType::create($data);
        return redirect()->route('flight-types.index')->with('success', 'Flight type created');
    }

    public function edit(FlightType $flight_type)
    {
        return view('flight_types.edit', ['item' => $flight_type]);
    }

    public function update(Request $request, FlightType $flight_type)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        $flight_type->update($data);
        return redirect()->route('flight-types.index')->with('success', 'Flight type updated');
    }

    public function destroy(FlightType $flight_type)
    {
        $flight_type->delete();
        return redirect()->route('flight-types.index')->with('success', 'Removed');
    }
}
