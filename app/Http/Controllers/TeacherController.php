<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Area;
use App\Models\Course;
use App\Models\TrainingCenter;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index() {
        $teachers = Teacher::all();
        return response()->json($teachers);
    }

    public function create() {
        $areas = Area::all();
        $trainingCenters = TrainingCenter::all();
        $courses = Course::all();
        return view('teachers.create', compact('areas', 'trainingCenters', 'courses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'                => 'required|string|max:255',
            'email'               => 'required|email|max:255|unique:teachers,email',
            'area_id'             => 'required|exists:areas,id',
            'training_center_id'  => 'required|exists:training_centers,id',
            'courses'             => 'nullable|array',
            'courses.*'           => 'exists:courses,id',
        ]);

        $teacher = Teacher::create($validatedData);

        if ($request->has('courses')) {
            $teacher->courses()->sync($request->courses);
        }

        $teacher->load('courses');

        return response()->json($teacher);
    }

    public function edit(Teacher $teacher) {
        $areas = Area::all();
        $trainingCenters = TrainingCenter::all();
        $courses = Course::all();
        return view('teachers.edit', compact('teacher', 'areas', 'trainingCenters', 'courses'));
    }

    public function update(Request $request, Teacher $teacher) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'area_id' => 'required|exists:areas,id',
            'training_center_id' => 'required|exists:training_centers,id',
        ]);
        $teacher->update($request->all());
        if ($request->has('courses')) {
            $teacher->courses()->sync($request->courses);
        } else {
            $teacher->courses()->detach();
        }
        return redirect()->route('teachers.index')->with('success', 'Instructor actualizado.');
    }

    public function destroy(Teacher $teacher) {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return response()->json([
                'message' => 'Instructor no encontrado.'
            ], 404);
        }
        $teacher->delete();
        return response()->json(['message' => 'Instructor eliminado.']);
    }
}
