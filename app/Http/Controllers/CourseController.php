<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Area;
use App\Models\TrainingCenter;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['area', 'trainingCenter'])->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $areas = Area::all();
        $trainingCenters = TrainingCenter::all();
        $teachers = Teacher::all();
        return view('courses.create', compact('areas', 'trainingCenters', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_number' => 'required|string|max:255',
            'day' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'training_center_id' => 'required|exists:training_centers,id',
        ]);

        $course = Course::create($request->all());
        if ($request->has('teachers')) {
            $course->teachers()->sync($request->teachers);
        }

        return redirect()->route('courses.index')->with('success', 'Curso creado con éxito.');
    }

    public function edit(Course $course)
    {
        $areas = Area::all();
        $trainingCenters = TrainingCenter::all();
        $teachers = Teacher::all();
        return view('courses.edit', compact('course', 'areas', 'trainingCenters', 'teachers'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_number' => 'required|string|max:255',
            'day' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'training_center_id' => 'required|exists:training_centers,id',
        ]);

        $course->update($request->all());
        if ($request->has('teachers')) {
            $course->teachers()->sync($request->teachers);
        }

        return redirect()->route('courses.index')->with('success', 'Curso actualizado con éxito.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Curso eliminado.');
    }
}
