@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Instructores</h2>
    <a href="{{ route('teachers.create') }}" class="btn btn-primary">Nuevo Instructor</a>
</div>

<table class="table table-striped bg-white border">
    <thead class="table-dark">
        <tr><th>ID</th><th>Nombre</th><th>Área</th><th>Centro</th><th>Acciones</th></tr>
    </thead>
    <tbody>
        @foreach($teachers as $teacher)
        <tr>
            <td>{{ $teacher->id }}</td>
            <td>{{ $teacher->name }}</td>
            <td><span class="badge bg-info text-dark">{{ $teacher->area->name }}</span></td>
            <td>{{ $teacher->trainingCenter->name }}</td>
            <td>
                <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
