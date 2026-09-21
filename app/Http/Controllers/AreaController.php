<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller{
    public function index(){
        return response()->json(Area::all(), 200);
    }

    public function store(Request $request){
        $validated = $request->validate(['name' => 'required|string|max:255']);
        $area = Area::create($validated);
        return response()->json($area, 201);
    }

    public function show(Area $area){
        return response()->json($area, 200);
    }

    public function update(Request $request, Area $area){
        $validated = $request->validate(['name' => 'required|string|max:255']);
        $area->update($validated);
        return response()->json($area, 200);
    }

    public function destroy(Area $area){
        $area->delete();
        return response()->json(['message' => 'Área eliminada exitosamente.'], 200);
    }
}
