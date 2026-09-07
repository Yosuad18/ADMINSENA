@extends('layouts.app')

@section('content')
<div class="card card-sena p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0" style="color: var(--sena-dark);">
            <i class="fas fa-chalkboard-teacher text-success me-2"></i>Gestión de Instructores
        </h3>
        <a href="{{ route('teachers.create') }}" class="btn btn-sena">
            <i class="fas fa-plus-circle me-1"></i> Nuevo Instructor
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
                    <th>Correo</th>
                    <th>Área</th>
                    <th>Centro de Formación</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td><strong>#{{ $teacher->id }}</strong></td>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->email ?? '—' }}</td>
                        <td><span class="badge bg-info text-dark">{{ $teacher->area->name ?? 'Sin área' }}</span></td>
                        <td>{{ $teacher->trainingCenter->name ?? 'Sin centro' }}</td>
                        <td class="text-center">
                            <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline-block">
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
                        <td colspan="6" class="text-center text-muted py-4">No hay instructores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
