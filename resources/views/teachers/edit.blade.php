@extends('layouts.app')

@section('content')
<h2>Editar Instructor</h2>
<form action="{{ route('teachers.update', $teacher) }}" method="POST" class="bg-white p-4 rounded border">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Nombre Completo</label>
        <input type="text" name="name" value="{{ $teacher->name }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Área</label>
        <select name="area_id" class="form-select" required>
            @foreach($areas as $area)
                <option value="{{ $area->id }}" {{ $teacher->area_id == $area->id ? 'selected' : '' }}>
                    {{ $area->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Centro de Formación</label>
        <select name="training_center_id" class="form-select" required>
            @foreach($trainingCenters as $center)
                <option value="{{ $center->id }}" {{ $teacher->training_center_id == $center->id ? 'selected' : '' }}>
                    {{ $center->name }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
