@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Centros de Formación</h2>
    <a href="{{ route('training-centers.create') }}" class="btn btn-primary">Nuevo Centro</a>
</div>

<table class="table table-striped bg-white border">
    <thead class="table-dark">
        <tr><th>ID</th><th>Nombre</th><th>Dirección</th><th>Acciones</th></tr>
    </thead>
    <tbody>
        @foreach($trainingCenters as $center)
        <tr>
            <td>{{ $center->id }}</td>
            <td>{{ $center->name }}</td>
            <td>{{ $center->address }}</td>
            <td>
                <a href="{{ route('training-centers.edit', $center) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('training-centers.destroy', $center) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
