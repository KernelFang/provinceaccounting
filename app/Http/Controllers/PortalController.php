<?php

namespace App\Http\Controllers;

use App\Models\Portal;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        $items = Portal::latest()->paginate(50);
        return view('portals.index', compact('items'));
    }

    public function create()
    {
        return view('portals.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        Portal::create($data);
        return redirect()->route('portals.index')->with('success', 'Portal created');
    }

    public function edit(Portal $portal)
    {
        return view('portals.edit', compact('portal'));
    }

    public function update(Request $request, Portal $portal)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        $portal->update($data);
        return redirect()->route('portals.index')->with('success', 'Portal updated');
    }

    public function destroy(Portal $portal)
    {
        $portal->delete();
        return redirect()->route('portals.index')->with('success', 'Portal removed');
    }
}
