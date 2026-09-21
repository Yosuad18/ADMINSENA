<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use Illuminate\Http\Request;

class ComputerController extends Controller{
    public function index(){
        return response()->json(Computer::all(), 200);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'number' => 'required|string|unique:computers,number',
            'brand'  => 'required|string|max:255',
        ]);

        $computer = Computer::create($validated);
        return response()->json($computer, 201);
    }

    public function show(Computer $computer){
        return response()->json($computer, 200);
    }

    public function update(Request $request, Computer $computer){
        $validated = $request->validate([
            'number' => 'required|string|unique:computers,number,' . $computer->id,
            'brand'  => 'required|string|max:255',
        ]);

        $computer->update($validated);
        return response()->json($computer, 200);
    }

    public function destroy(Computer $computer){
        $computer->delete();
        return response()->json(['message' => 'Equipo eliminado exitosamente.'], 200);
    }
}

