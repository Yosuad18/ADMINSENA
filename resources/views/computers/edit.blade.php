@extends('layouts.app')

@section('content')
<h2>Registrar Computador</h2>
<form action="{{ route('computers.store') }}" method="POST" class="bg-white p-4 rounded border">
    @csrf
    <div class="mb-3">
        <label class="form-label">Marca</label>
        <input type="text" name="brand" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Número Serial</label>
        <input type="text" name="serial_number" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('computers.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
