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

    public function create()
    {
        $courses = Course::all();
        $computers = Computer::all();

        return view('apprentices.create', compact('courses', 'computers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'document' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'estrato' => 'nullable|integer|between:1,6',
            'email' => 'required|email|unique:apprentices,email',
            'cell_number' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'computer_id' => 'nullable|exists:computers,id',
        ]);

        Apprentice::create($request->all());

        return redirect()->route('apprentices.index')->with('success', 'Aprendiz creado con éxito.');
    }

    public function edit(Apprentice $apprentice)
    {
        $courses = Course::all();
        $computers = Computer::all();

        return view('apprentices.edit', compact('apprentice', 'courses', 'computers'));
    }

    public function update(Request $request, Apprentice $apprentice)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'document' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'estrato' => 'nullable|integer|between:1,6',
            'email' => 'required|email|unique:apprentices,email,'.$apprentice->id,
            'cell_number' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'computer_id' => 'nullable|exists:computers,id',
        ]);

        $apprentice->update($request->all());

        return redirect()->route('apprentices.index')->with('success', 'Aprendiz actualizado con éxito.');
    }

    public function destroy(Apprentice $apprentice)
    {
        $apprentice->delete();

        return redirect()->route('apprentices.index')->with('success', 'Aprendiz eliminado.');
    }
}
