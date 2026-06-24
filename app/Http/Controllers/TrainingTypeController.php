<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use Illuminate\Http\Request;

class TrainingTypeController extends Controller
{
    public function index()
    {
        $items = TrainingType::latest()->paginate(50);
        return view('training_types.index', compact('items'));
    }

    public function create()
    {
        return view('training_types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:191|unique:training_types,name']);
        TrainingType::create($data);
        return redirect()->route('training-types.index')->with('success', 'Training type created');
    }

    public function edit(TrainingType $trainingType)
    {
        return view('training_types.edit', ['trainingType' => $trainingType]);
    }

    public function update(Request $request, TrainingType $trainingType)
    {
        $data = $request->validate(['name' => 'required|string|max:191|unique:training_types,name,' . $trainingType->id]);
        $trainingType->update($data);
        return redirect()->route('training-types.index')->with('success', 'Training type updated');
    }

    public function destroy(TrainingType $trainingType)
    {
        $trainingType->delete();
        return redirect()->route('training-types.index')->with('success', 'Training type removed');
    }
}
