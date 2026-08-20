@extends('layouts.app')

@section('content')
<h2>Editar Área</h2>
<form action="{{ route('areas.update', $area) }}" method="POST" class="bg-white p-4 rounded border">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Nombre del Área</label>
        <input type="text" name="name" value="{{ $area->name }}" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('areas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
