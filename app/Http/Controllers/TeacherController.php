<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Area;
use App\Models\TrainingCenter;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index() {
        $teachers = Teacher::with(['area', 'trainingCenter'])->get();
        return view('teachers.index', compact('teachers'));
    }

    public function create() {
        $areas = Area::all();
        $trainingCenters = TrainingCenter::all();
        return view('teachers.create', compact('areas', 'trainingCenters'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'training_center_id' => 'required|exists:training_centers,id',
        ]);
        Teacher::create($request->all());
        return redirect()->route('teachers.index')->with('success', 'Instructor registrado.');
    }

    public function edit(Teacher $teacher) {
        $areas = Area::all();
        $trainingCenters = TrainingCenter::all();
        return view('teachers.edit', compact('teacher', 'areas', 'trainingCenters'));
    }

    public function update(Request $request, Teacher $teacher) {
        $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'training_center_id' => 'required|exists:training_centers,id',
        ]);
        $teacher->update($request->all());
        return redirect()->route('teachers.index')->with('success', 'Instructor actualizado.');
    }

    public function destroy(Teacher $teacher) {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Instructor eliminado.');
    }
}
