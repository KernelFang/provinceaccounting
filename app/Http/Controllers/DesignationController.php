<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Http\Requests\DesignationRequest;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::latest()->paginate(20);
        return view('designations.index', compact('designations'));
    }

    public function create()
    {
        return view('designations.create');
    }

    public function store(DesignationRequest $request)
    {
        Designation::create($request->validated());
        return redirect()->route('designations.index');
    }

    public function edit(Designation $designation)
    {
        return view('designations.edit', compact('designation'));
    }

    public function update(DesignationRequest $request, Designation $designation)
    {
        $designation->update($request->validated());
        return redirect()->route('designations.index');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return redirect()->route('designations.index');
    }
}
