@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Áreas Tecnológicas</h2>
    <a href="{{ route('areas.create') }}" class="btn btn-primary">Nueva Área</a>
</div>

<table class="table table-striped bg-white border">
    <thead class="table-dark">
        <tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>
    </thead>
    <tbody>
        @foreach($areas as $area)
        <tr>
            <td>{{ $area->id }}</td>
            <td>{{ $area->name }}</td>
            <td>
                <a href="{{ route('areas.edit', $area) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('areas.destroy', $area) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
