<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
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

        $teacher = Teacher::create($validated);

        if ($request->has('courses')) {
            $pivotData = [];
            foreach ($request->courses as $courseId) {
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

    public function update(Request $request, Teacher $teacher){
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|max:255|unique:teachers,email,' . $teacher->id,
            'area_id'            => 'required|exists:areas,id',
            'training_center_id' => 'required|exists:training_centers,id',
            'courses'            => 'nullable|array',
            'courses.*'          => 'exists:courses,id',
        ]);

        $teacher->update($validated);

        if ($request->has('courses')) {
            $pivotData = [];
            foreach ($request->courses as $courseId) {
                $pivotData[$courseId] = [
                    'name'  => $teacher->name,
                    'email' => $teacher->email,
                ];
            }
            $teacher->courses()->sync($pivotData);
        } else {
            $teacher->courses()->detach();
        }

        $teacher->load(['area', 'trainingCenter', 'courses']);
        return response()->json($teacher, 200);
    }

    public function destroy(Teacher $teacher){
        $teacher->delete();
        return response()->json(['message' => 'Instructor eliminado exitosamente.'], 200);
    }
}
