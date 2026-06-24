<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function index()
    {
        $items = Airline::latest()->paginate(50);
        return view('airlines.index', compact('items'));
    }

    public function create()
    {
        return view('airlines.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        Airline::create($data);
        return redirect()->route('airlines.index')->with('success', 'Airline created');
    }

    public function edit(Airline $airline)
    {
        return view('airlines.edit', ['item' => $airline]);
    }

    public function update(Request $request, Airline $airline)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        $airline->update($data);
        return redirect()->route('airlines.index')->with('success', 'Airline updated');
    }

    public function destroy(Airline $airline)
    {
        $airline->delete();
        return redirect()->route('airlines.index')->with('success', 'Removed');
    }
}
