<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Area;
use App\Models\Course;
use App\Models\TrainingCenter;
use Illuminate\Http\Request;

class TeacherController extends Controller{
    public function index(){
        $teachers = Teacher::with(['area', 'trainingCenter', 'courses'])->get();
        return response()->json($teachers, 200);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|max:255|unique:teachers,email',
            'area_id'            => 'required|exists:areas,id',
            'training_center_id' => 'required|exists:training_centers,id',
            'courses'            => 'nullable|array',
            'courses.*'          => 'exists:courses,id',
        ]);

        $courseIds = $validated['courses'] ?? [];
        unset($validated['courses']);
        $teacher = Teacher::create($validated);

        if ($request->has('courses')) {
            $pivotData = [];
            foreach ($courseIds as $courseId) {
                $pivotData[$courseId] = [
                    'name'  => $teacher->name,
                    'email' => $teacher->email,
                ];
            }
            $teacher->courses()->sync($pivotData);
        }

        $teacher->load(['area', 'trainingCenter', 'courses']);
        return response()->json($teacher, 201);
    }

    public function show(Teacher $teacher){
        $teacher->load(['area', 'trainingCenter', 'courses']);
        return response()->json($teacher, 200);
    }

    public function edit(Teacher $teacher){
        $teacher->load('courses');

        return view('teachers.edit', [
            'teacher' => $teacher,
            'areas' => Area::all(),
            'trainingCenters' => TrainingCenter::all(),
            'courses' => Course::all(),
        ]);
    }

    public function update(Request $request, Teacher $teacher){
        $validated = $request->validate([
            'name'               => 'sometimes|required|string|max:255',
            'email'              => 'sometimes|required|email|max:255|unique:teachers,email,' . $teacher->id,
            'area_id'            => 'sometimes|required|exists:areas,id',
            'training_center_id' => 'sometimes|required|exists:training_centers,id',
            'courses'            => 'sometimes|nullable|array',
            'courses.*'          => 'exists:courses,id',
        ]);

        $courseIds = $validated['courses'] ?? null;
        $hasCourses = array_key_exists('courses', $validated);
        unset($validated['courses']);
        $teacher->update($validated);

        if ($hasCourses) {
            $pivotData = [];
            foreach ($courseIds ?? [] as $courseId) {
                $pivotData[$courseId] = [
                    'name'  => $teacher->name,
                    'email' => $teacher->email,
                ];
            }
            $teacher->courses()->sync($pivotData);
        }

        $teacher->load(['area', 'trainingCenter', 'courses']);

        if ($request->expectsJson()) {
            return response()->json($teacher, 200);
        }

        return redirect()->route('admin.panel')->with('success', 'Instructor actualizado exitosamente.');
    }

    public function destroy(Teacher $teacher){
        $teacher->delete();
        return response()->json(['message' => 'Instructor eliminado exitosamente.'], 200);
    }
}
