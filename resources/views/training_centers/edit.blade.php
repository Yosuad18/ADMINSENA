@extends('layouts.app')

@section('content')
<h2>Editar Centro de Formación</h2>
<form action="{{ route('training-centers.update', $trainingCenter) }}" method="POST" class="bg-white p-4 rounded border">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Nombre del Centro</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $trainingCenter->name) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $trainingCenter->address) }}" placeholder="Ej: Calle 4 No. 2-80, Popayán, Cauca">
    </div>
    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="{{ route('training-centers.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
