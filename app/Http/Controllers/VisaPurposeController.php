<?php

namespace App\Http\Controllers;

use App\Models\VisaPurpose;
use Illuminate\Http\Request;

class VisaPurposeController extends Controller
{
    public function index()
    {
        $items = VisaPurpose::latest()->paginate(50);
        return view('visa_purposes.index', compact('items'));
    }

    public function create()
    {
        return view('visa_purposes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        VisaPurpose::create($data);
        return redirect()->route('visa-purposes.index')->with('success', 'Visa Purpose created');
    }

    public function edit(VisaPurpose $visaPurpose)
    {
        return view('visa_purposes.edit', ['item' => $visaPurpose]);
    }

    public function update(Request $request, VisaPurpose $visaPurpose)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        $visaPurpose->update($data);
        return redirect()->route('visa-purposes.index')->with('success', 'Visa Purpose updated');
    }

    public function destroy(VisaPurpose $visaPurpose)
    {
        $visaPurpose->delete();
        return redirect()->route('visa-purposes.index')->with('success', 'Removed');
    }
}
