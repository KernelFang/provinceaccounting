<?php

namespace App\Http\Controllers;

use App\Models\Purpose;
use Illuminate\Http\Request;

class PurposeController extends Controller
{
    public function index()
    {
        $items = Purpose::latest()->paginate(50);
        return view('purposes.index', compact('items'));
    }

    public function create()
    {
        return view('purposes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        Purpose::create($data);
        return redirect()->route('purposes.index')->with('success', 'Purpose created');
    }

    public function edit(Purpose $purpose)
    {
        return view('purposes.edit', ['item' => $purpose]);
    }

    public function update(Request $request, Purpose $purpose)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        $purpose->update($data);
        return redirect()->route('purposes.index')->with('success', 'Purpose updated');
    }

    public function destroy(Purpose $purpose)
    {
        $purpose->delete();
        return redirect()->route('purposes.index')->with('success', 'Removed');
    }
}
