@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Asignación de Instructores a Cursos</h2>
    <a href="{{ route('course_teachers.create') }}" class="btn btn-primary">Asignar Instructor</a>
</div>

<table class="table table-bordered bg-white">
    <thead class="table-dark">
        <tr>
            <th>ID Asignación</th>
            <th>Curso</th>
            <th>Instructor</th>
            <th>Fecha de Registro</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courseTeachers as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td><strong>{{ $item->course->name }}</strong></td>
            <td>{{ $item->teacher->name }}</td>
            <td>{{ $item->created_at->format('d/m/Y') }}</td>
            <td>
                <form action="{{ route('course_teachers.destroy', $item) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Desvincular instructor de este curso?')">
                        Desvincular
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
