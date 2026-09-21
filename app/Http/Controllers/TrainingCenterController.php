<?php

namespace App\Http\Controllers;

use App\Models\TrainingCenter;
use Illuminate\Http\Request;

class TrainingCenterController extends Controller{
    public function index(){
        return response()->json(TrainingCenter::all(), 200);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $trainingCenter = TrainingCenter::create($validated);
        return response()->json($trainingCenter, 201);
    }

    public function show(TrainingCenter $trainingCenter){
        return response()->json($trainingCenter, 200);
    }

    public function update(Request $request, TrainingCenter $trainingCenter){
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $trainingCenter->update($validated);
        return response()->json($trainingCenter, 200);
    }

    public function destroy(TrainingCenter $trainingCenter){
        $trainingCenter->delete();
        return response()->json(['message' => 'Centro de formación eliminado exitosamente.'], 200);
    }
}
