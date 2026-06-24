<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        $items = Info::latest()->paginate(50);
        return view('infos.index', compact('items'));
    }

    public function create()
    {
        return view('infos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        Info::create($data);
        return redirect()->route('infos.index')->with('success', 'Info created');
    }

    public function edit(Info $info)
    {
        return view('infos.edit', ['item' => $info]);
    }

    public function update(Request $request, Info $info)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        $info->update($data);
        return redirect()->route('infos.index')->with('success', 'Info updated');
    }

    public function destroy(Info $info)
    {
        $info->delete();
        return redirect()->route('infos.index')->with('success', 'Removed');
    }
}
