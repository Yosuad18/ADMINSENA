<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller{
    public function index(){
        $courses = Course::with(['area', 'trainingCenter', 'teachers'])->get();
        return response()->json($courses, 200);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'course_number'      => 'required|string|max:255',
            'name'               => 'nullable|string|max:255',
            'day'                => 'required|string|max:255',
            'deadline'           => 'nullable|date',
            'image'              => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'area_id'            => 'required|exists:areas,id',
            'training_center_id' => 'required|exists:training_centers,id',
            'teachers'           => 'nullable|array',
            'teachers.*'         => 'exists:teachers,id',
        ]);

        $data = $request->except(['image', 'teachers']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = "sena_" . time() . "." . $file->guessExtension();
            $file->storeAs('public/images', $fileName);
            $data['image'] = $fileName;
        }

        $course = Course::create($data);

        if ($request->has('teachers')) {
            $teachersData = [];
            $teachers = Teacher::findMany($request->teachers);

            foreach ($teachers as $teacher) {
                $teachersData[$teacher->id] = [
                    'name'  => $teacher->name,
                    'email' => $teacher->email,
                ];
            }
            $course->teachers()->sync($teachersData);
        }

        $course->load(['area', 'trainingCenter', 'teachers']);
        return response()->json($course, 201);
    }

    public function show(Course $course){
        $course->load(['area', 'trainingCenter', 'teachers']);
        return response()->json($course, 200);
    }

    public function update(Request $request, Course $course){
        $validated = $request->validate([
            'course_number'      => 'required|string|max:255',
            'name'               => 'nullable|string|max:255',
            'day'                => 'required|string|max:255',
            'deadline'           => 'nullable|date',
            'image'              => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'area_id'            => 'required|exists:areas,id',
            'training_center_id' => 'required|exists:training_centers,id',
            'teachers'           => 'nullable|array',
            'teachers.*'         => 'exists:teachers,id',
        ]);

        $data = $request->except(['image', 'teachers']);

        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::delete('public/images/' . $course->image);
            }

            $file = $request->file('image');
            $fileName = "sena_" . time() . "." . $file->guessExtension();
            $file->storeAs('public/images', $fileName);
            $data['image'] = $fileName;
        }

        $course->update($data);

        if ($request->has('teachers')) {
            $teachersData = [];
            $teachers = Teacher::findMany($request->teachers);

            foreach ($teachers as $teacher) {
                $teachersData[$teacher->id] = [
                    'name'  => $teacher->name,
                    'email' => $teacher->email,
                ];
            }
            $course->teachers()->sync($teachersData);
        } else {
            $course->teachers()->detach();
        }

        $course->load(['area', 'trainingCenter', 'teachers']);
        return response()->json($course, 200);
    }

    public function destroy(Course $course){
        if ($course->image) {
            Storage::delete('public/images/' . $course->image);
        }

        $course->delete();
        return response()->json(['message' => 'Curso eliminado exitosamente.'], 200);
    }
}
