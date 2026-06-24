<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlatStoreRequest;
use App\Http\Requests\FlatUpdateRequest;
use App\Models\Client;
use App\Models\Flat;
use App\Models\Project;
use Illuminate\Http\Request;

class FlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Flat::with(['project', 'currentOwner']);

        if ($projectId = $request->query('project_id')) {
            $query->where('project_id', $projectId);
        }

        if ($status = $request->query('client_owner_status')) {
            $query->where('client_owner_status', $status);
        }

        if ($search = $request->query('search')) {
            $query->where(fn ($q) => $q->where('building_no', 'like', "%{$search}%")
                ->orWhere('floor_no', 'like', "%{$search}%")
                ->orWhere('flat_no', 'like', "%{$search}%"));
        }

        $flats = $query->latest()->paginate(25)->appends($request->query());
        $projects = Project::orderBy('name')->get();

        return view('flats.index', compact('flats', 'projects'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();
        $clients = Client::orderBy('first_name')->get();

        return view('flats.create', compact('projects', 'clients'));
    }

    public function store(FlatStoreRequest $request)
    {
        $data = $request->validated();
        $data['is_reselled'] = $request->boolean('is_reselled');
        Flat::create($data);

        return redirect()->route('flats.index')->with('success', 'Flat created successfully.');
    }

    public function show(Flat $flat)
    {
        return view('flats.show', compact('flat'));
    }

    public function edit(Flat $flat)
    {
        $projects = Project::orderBy('name')->get();
        $clients = Client::orderBy('first_name')->get();

        return view('flats.edit', compact('flat', 'projects', 'clients'));
    }

    public function update(FlatUpdateRequest $request, Flat $flat)
    {
        $data = $request->validated();
        $data['is_reselled'] = $request->boolean('is_reselled');
        $flat->update($data);

        return redirect()->route('flats.index')->with('success', 'Flat updated successfully.');
    }

    public function destroy(Flat $flat)
    {
        $flat->delete();

        return redirect()->route('flats.index')->with('success', 'Flat deleted successfully.');
    }
}
