<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use Illuminate\Http\Request;

class ComputerController extends Controller
{
    public function index() {
        $computers = Computer::all();
        return view('computers.index', compact('computers'));
    }

    public function create() {
        return view('computers.create');
    }

    public function store(Request $request) {
        $request->validate([
            'serial_number' => 'required|unique:computers,serial_number',
            'brand' => 'required|string|max:255',
        ]);
        Computer::create($request->all());
        return redirect()->route('computers.index')->with('success', 'Equipo registrado.');
    }

    public function edit(Computer $computer) {
        return view('computers.edit', compact('computer'));
    }

    public function update(Request $request, Computer $computer) {
        $request->validate([
            'serial_number' => 'required|unique:computers,serial_number,'.$computer->id,
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
