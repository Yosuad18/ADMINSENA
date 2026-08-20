@extends('layouts.app')

@section('content')
<h2>Crear Área</h2>
<form action="{{ route('areas.store') }}" method="POST" class="bg-white p-4 rounded border">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nombre del Área</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('areas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
