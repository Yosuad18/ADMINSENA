@extends('layouts.app')

@section('content')
<div class="card card-sena p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0" style="color: var(--sena-dark);">
            <i class="fas fa-user-graduate text-success me-2"></i>Gestión de Aprendices
        </h3>
        <a href="{{ route('apprentices.create') }}" class="btn btn-sena">
            <i class="fas fa-user-plus me-1"></i> Registrar Aprendiz
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
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Correo</th>
                    <th>Estrato</th>
                    <th>Curso / Ficha</th>
                    <th>Equipo Asignado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($apprentices as $apprentice)
                    <tr>
                        <td><strong>#{{ $apprentice->id }}</strong></td>
                        <td>{{ $apprentice->name }} {{ $apprentice->surname }}</td>
                        <td>{{ $apprentice->document ?? '—' }}</td>
                        <td>{{ $apprentice->email }}</td>
                        <td>{{ $apprentice->estrato ? 'Estrato ' . $apprentice->estrato : '—' }}</td>
                        <td><span class="badge bg-secondary">{{ $apprentice->course->course_number ?? 'Sin curso' }}</span></td>
                        <td>{{ $apprentice->computer->brand ?? 'Sin equipo' }}</td>
                        <td class="text-center">
                            <a href="{{ route('apprentices.edit', $apprentice) }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('apprentices.destroy', $apprentice) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Confirma la eliminación del aprendiz?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No hay aprendices registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
