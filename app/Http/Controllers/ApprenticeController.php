<?php

namespace App\Http\Controllers;

use App\Models\Apprentice;
use App\Models\Computer;
use App\Models\Course;
use Illuminate\Http\Request;

class ApprenticeController extends Controller
{
    public function index()
    {
        $apprentices = Apprentice::with(['course', 'computer'])->get();
        return view('apprentices.index', compact('apprentices'));
    }

    public function edit(Apprentice $apprentice)
    {
        return view('apprentices.edit', [
            'apprentice' => $apprentice,
            'courses' => Course::all(),
            'computers' => Computer::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'surname'     => 'nullable|string|max:255',
            'document'    => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:255',
            'estrato'     => 'nullable|integer|between:1,6',
            'email'       => 'required|email|unique:apprentices,email',
            'cell'        => 'nullable|string|max:255',
            'course_id'   => 'required|exists:courses,id',
            'computer_id' => 'nullable|exists:computers,id',
        ]);

        Apprentice::create($validated);

        return redirect()->route('apprentices.index')->with('success', 'Aprendiz creado exitosamente.');
    }

    public function update(Request $request, Apprentice $apprentice)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'surname'     => 'nullable|string|max:255',
            'document'    => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:255',
            'estrato'     => 'nullable|integer|between:1,6',
            'email'       => 'required|email|unique:apprentices,email,' . $apprentice->id,
            'cell'        => 'nullable|string|max:255',
            'course_id'   => 'required|exists:courses,id',
            'computer_id' => 'nullable|exists:computers,id',
        ]);

        $apprentice->update($validated);

        if ($request->expectsJson()) {
            return response()->json($apprentice, 200);
        }

        return redirect()->route('apprentices.index')->with('success', 'Aprendiz actualizado exitosamente.');
    }

    public function destroy(Apprentice $apprentice)
    {
        $apprentice->delete();
        return redirect()->route('apprentices.index')->with('success', 'Aprendiz eliminado exitosamente.');
    }
}
