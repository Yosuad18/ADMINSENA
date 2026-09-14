<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use Illuminate\Http\Request;

class ComputerController extends Controller
{
    public function index() {
        $computers = Computer::all();
        return response()->json($computers);
    }

    public function create() {
        return view('computers.create');
    }

    public function store(Request $request) {
        $request->validate([
            'number' => 'required|unique:computers,number',
            'brand' => 'required|string|max:255',
        ]);
        $computer = Computer::create($request->all());
        return response()->json($computer);
    }

    public function edit(Computer $computer) {
        return view('computers.edit', compact('computer'));
    }

    public function update(Request $request, Computer $computer) {
        $request->validate([
            'number' => 'required|unique:computers,number,'.$computer->id,
            'brand' => 'required|string|max:255',
        ]);
        $computer->update($request->all());
        return redirect()->route('computers.index')->with('success', 'Equipo actualizado.');
    }

    public function destroy(Computer $computer) {
        $computer->delete();
        return redirect()->route('computers.index')->with('success', 'Equipo eliminado.');
    }
}
