<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function index()
    {
        $items = ServiceType::latest()->paginate(50);
        return view('service_types.index', compact('items'));
    }

    public function create()
    {
        return view('service_types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        ServiceType::create($data);
        return redirect()->route('service-types.index')->with('success', 'Service type created');
    }

    public function edit(ServiceType $service_type)
    {
        return view('service_types.edit', ['item' => $service_type]);
    }

    public function update(Request $request, ServiceType $service_type)
    {
        $data = $request->validate(['name' => 'required|string|max:191']);
        $service_type->update($data);
        return redirect()->route('service-types.index')->with('success', 'Service type updated');
    }

    public function destroy(ServiceType $service_type)
    {
        $service_type->delete();
        return redirect()->route('service-types.index')->with('success', 'Removed');
    }
}
