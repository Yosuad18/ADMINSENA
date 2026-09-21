<?php

namespace App\Http\Controllers;

use App\Models\TrainingCenter;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TrainingCenterController extends Controller
{
    public function index(){
        $trainingCenters = TrainingCenter::all();
        return response()->json($trainingCenters, 200);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $trainingCenter = TrainingCenter::create($validatedData);

        return response()->json($trainingCenter, 201);
    }

    public function show(TrainingCenter $trainingCenter){
        return response()->json($trainingCenter, 200);
    }

    public function update(Request $request, TrainingCenter $trainingCenter){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $trainingCenter->update($validatedData);

        return response()->json($trainingCenter, 200);
    }

    public function destroy(TrainingCenter $trainingCenter){
        try {
            $trainingCenter->delete();

            return response()->json([
                'message' => 'Centro de formación eliminado con éxito.'
            ], 200);

        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'No se puede eliminar el centro de formación porque tiene áreas, cursos o personal asociados.'
                ], 409);
            }

            return response()->json([
                'message' => 'Error interno al intentar eliminar el registro.'
            ], 500);
        }
    }
}
