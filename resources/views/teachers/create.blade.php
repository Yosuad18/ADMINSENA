@extends('layouts.app')

@section('content')
<h2>Registrar Instructor</h2>
<form action="{{ route('teachers.store') }}" method="POST" class="bg-white p-4 rounded border">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nombre Completo</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Área</label>
        <select name="area_id" class="form-select" required>
            <option value="">Seleccione...</option>
            @foreach($areas as $area)
                <option value="{{ $area->id }}">{{ $area->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Centro de Formación</label>
        <select name="training_center_id" class="form-select" required>
            <option value="">Seleccione...</option>
            @foreach($trainingCenters as $center)
                <option value="{{ $center->id }}">{{ $center->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
