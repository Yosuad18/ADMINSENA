<?php

namespace App\Http\Controllers;

use App\Models\Apprentice;
use Illuminate\Http\Request;

class ApprenticeController extends Controller{
    public function index(){
        $apprentices = Apprentice::with(['course', 'computer'])->get();
        return response()->json($apprentices, 200);
    }

    public function store(Request $request){
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

        $apprentice = Apprentice::create($validated);
        return response()->json($apprentice, 201);
    }

    public function show(Apprentice $apprentice){
        $apprentice->load(['course', 'computer']);
        return response()->json($apprentice, 200);
    }

    public function update(Request $request, Apprentice $apprentice){
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
        return response()->json($apprentice, 200);
    }

    public function destroy(Apprentice $apprentice){
        $apprentice->delete();
        return response()->json(['message' => 'Aprendiz eliminado exitosamente.'], 200);
    }
}
