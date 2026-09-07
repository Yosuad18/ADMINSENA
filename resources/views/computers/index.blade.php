@extends('layouts.app')

@section('content')
<div class="card card-sena p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0" style="color: var(--sena-dark);">
            <i class="fas fa-desktop text-success me-2"></i>Gestión de Equipos de Cómputo
        </h3>
        <a href="{{ route('computers.create') }}" class="btn btn-sena">
            <i class="fas fa-plus-circle me-1"></i> Nuevo Equipo
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle table-sena">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Número Serial</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($computers as $computer)
                    <tr>
                        <td><strong>#{{ $computer->id }}</strong></td>
                        <td>{{ $computer->brand }}</td>
                        <td><code>{{ $computer->number }}</code></td>
                        <td class="text-center">
                            <a href="{{ route('computers.edit', $computer) }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('computers.destroy', $computer) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Confirma la eliminación?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No hay equipos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
