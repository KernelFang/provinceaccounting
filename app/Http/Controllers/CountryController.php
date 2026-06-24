<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $items = Country::latest()->paginate(50);
        return view('countries.index', compact('items'));
    }

    public function create()
    {
        return view('countries.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        Country::create($data);
        return redirect()->route('countries.index')->with('success', 'Country created');
    }

    public function edit(Country $country)
    {
        return view('countries.edit', ['item' => $country]);
    }

    public function update(Request $request, Country $country)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        $country->update($data);
        return redirect()->route('countries.index')->with('success', 'Country updated');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('countries.index')->with('success', 'Removed');
    }
}
