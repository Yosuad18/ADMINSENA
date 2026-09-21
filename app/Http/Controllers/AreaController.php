<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index() {
        $areas = Area::all();
        return response()->json($areas);
    }

    public function create() {
        return view('areas.create');
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        $area = Area::create($request->all());
        return response()->json($area);
    }

    public function edit(Area $area) {
        return view('areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area) {
        $request->validate(['name' => 'required|string|max:255']);
        $area->update($request->all());
        return redirect()->route('areas.index')->with('success', 'Área actualizada.');
    }

    public function destroy($id) {
        $area = Area::find($id);
        if (!$area) {
            return response()->json([
                'message' => 'Área no encontrada.'
            ], 404);
    }
        $area->delete();
        return response()->json(['message' => 'Área eliminada.']);
    }
}
