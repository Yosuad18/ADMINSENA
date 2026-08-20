@extends('layouts.app')

@section('content')
<h2>Editar Curso</h2>
<form action="{{ route('courses.update', $course) }}" method="POST" class="bg-white p-4 rounded border">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Nombre del Curso</label>
        <input type="text" name="name" value="{{ $course->name }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Área</label>
        <select name="area_id" class="form-select" required>
            @foreach($areas as $area)
                <option value="{{ $area->id }}" {{ $course->area_id == $area->id ? 'selected' : '' }}>
                    {{ $area->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Centro de Formación</label>
        <select name="training_center_id" class="form-select" required>
            @foreach($trainingCenters as $center)
                <option value="{{ $center->id }}" {{ $course->training_center_id == $center->id ? 'selected' : '' }}>
                    {{ $center->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label d-block">Instructores Asignados</label>
        @foreach($teachers as $teacher)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="teachers[]" value="{{ $teacher->id }}"
                    id="t_{{ $teacher->id }}"
                    {{ $course->teachers->contains($teacher->id) ? 'checked' : '' }}>
                <label class="form-check-label" for="t_{{ $teacher->id }}">{{ $teacher->name }}</label>
            </div>
        @endforeach
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
