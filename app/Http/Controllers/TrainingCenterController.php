<?php

namespace App\Http\Controllers;

use App\Models\TrainingCenter;
use Illuminate\Http\Request;

class TrainingCenterController extends Controller
{
    public function index() {
        $trainingCenters = TrainingCenter::all();
        return response()->json($trainingCenters);
    }

    public function create() {
        return view('training_centers.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);
        $trainingCenter = TrainingCenter::create($request->all());
        return response()->json($trainingCenter);
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
        $trainingCenter = TrainingCenter::find($id);
        if (!$trainingCenter) {
            return response()->json([
                'message' => 'Centro no encontrado.'
            ], 404);
        }
        $trainingCenter->delete();
        return response()->json(['message' => 'Centro eliminado.']);
    }
}
