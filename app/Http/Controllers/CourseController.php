<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\TrainingCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['area', 'trainingCenter', 'teachers'])->get();

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
            $nombreArchivo = "sena_" . time() . "." . $file->guessExtension();
            $file->storeAs('public/images', $nombreArchivo);
            $data['image'] = $nombreArchivo;
        }

        $course = Course::create($data);

        // Sincronizar profesores rellenando 'name' y 'email' requeridos por la tabla pivote
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
            // Eliminar imagen anterior si existe
            if ($course->image) {
                Storage::delete('public/images/' . $course->image);
            }

            $file = $request->file('image');
            $nombreArchivo = "sena_" . time() . "." . $file->guessExtension();
            $file->storeAs('public/images', $nombreArchivo);
            $data['image'] = $nombreArchivo;
        }

        $course->update($data);

        // Sincronizar profesores rindiendo los valores requeridos en la tabla pivote
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

        return redirect()->route('courses.index')->with('success', 'Curso actualizado con éxito.');
    }

    public function updateImage(Request $request, Course $course)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        if ($course->image) {
            Storage::delete('public/images/' . $course->image);
        }

        $file = $request->file('image');
        $nombreArchivo = "sena_" . time() . "." . $file->guessExtension();
        $file->storeAs('public/images', $nombreArchivo);

        $course->update(['image' => $nombreArchivo]);

        return redirect()->route('courses.index')->with('success', 'Imagen actualizada con éxito.');
    }

    public function destroy(Course $course)
    {
        if ($course->image) {
            Storage::delete('public/images/' . $course->image);
        }

        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Curso eliminado.');
    }
}
