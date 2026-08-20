<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index() {
        $areas = Area::all();
        return view('areas.index', compact('areas'));
    }

    public function create() {
        return view('areas.create');
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        Area::create($request->all());
        return redirect()->route('areas.index')->with('success', 'Área creada exitosamente.');
    }

    public function edit(Area $area) {
        return view('areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area) {
        $request->validate(['name' => 'required|string|max:255']);
        $area->update($request->all());
        return redirect()->route('areas.index')->with('success', 'Área actualizada.');
    }

    public function destroy(Area $area) {
        $area->delete();
        return redirect()->route('areas.index')->with('success', 'Área eliminada.');
    }
}
