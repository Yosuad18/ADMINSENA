<?php

namespace App\Http\Controllers;

use App\Models\TrainingCenter;
use Illuminate\Http\Request;

class TrainingCenterController extends Controller
{
    public function index() {
        $trainingCenters = TrainingCenter::all();
        return view('training_centers.index', compact('trainingCenters'));
    }

    public function create() {
        return view('training_centers.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);
        TrainingCenter::create($request->only('name', 'address'));
        return redirect()->route('training-centers.index')->with('success', 'Centro creado.');
    }

    public function edit(TrainingCenter $trainingCenter) {
        return view('training_centers.edit', compact('trainingCenter'));
    }

    public function update(Request $request, TrainingCenter $trainingCenter) {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);
        $trainingCenter->update($request->only('name', 'address'));
        return redirect()->route('training-centers.index')->with('success', 'Centro actualizado.');
    }

    public function destroy(TrainingCenter $trainingCenter) {
        $trainingCenter->delete();
        return redirect()->route('training-centers.index')->with('success', 'Centro eliminado.');
    }
}
