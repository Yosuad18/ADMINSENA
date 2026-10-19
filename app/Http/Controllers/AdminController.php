<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller{
    public function index(){
        return response()->json(Admin::all(), 200);
    }

    public function store(Request $request){
        $validated = $request->validate(['name' => 'required|string|max:255']);
        $admin = Admin::create($validated);
        return response()->json($admin, 201);
    }

    public function show(Admin $admin){
        return response()->json($admin, 200);
    }

    public function update(Request $request, Admin $admin){
        $validated = $request->validate(['name' => 'sometimes|required|string|max:255']);
        $admin->update($validated);
        return response()->json($admin, 200);
    }

    public function destroy(Admin $admin){
        $admin->delete();
        return response()->json(['message' => 'Administrador eliminado exitosamente.'], 200);
    }
}
