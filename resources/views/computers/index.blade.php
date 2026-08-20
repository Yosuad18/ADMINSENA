@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Equipos de Cómputo</h2>
    <a href="{{ route('computers.create') }}" class="btn btn-primary">Nuevo Equipo</a>
</div>

<table class="table table-striped bg-white border">
    <thead class="table-dark">
        <tr><th>ID</th><th>Marca</th><th>Serial</th><th>Acciones</th></tr>
    </thead>
    <tbody>
        @foreach($computers as $computer)
        <tr>
            <td>{{ $computer->id }}</td>
            <td>{{ $computer->brand }}</td>
            <td><code>{{ $computer->serial_number }}</code></td>
            <td>
                <a href="{{ route('computers.edit', $computer) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('computers.destroy', $computer) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
