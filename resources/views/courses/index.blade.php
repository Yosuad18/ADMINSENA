@extends('layouts.app')

@section('content')
<div class="card card-sena p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0" style="color: var(--sena-dark);">
            <i class="fas fa-layer-group text-success me-2"></i>Gestión de Cursos y Fichas
        </h3>
        <a href="{{ route('courses.create') }}" class="btn btn-sena">
            <i class="fas fa-plus-circle me-1"></i> Nuevo Curso
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
                    <th>N° Ficha / Curso</th>
                    <th>Programa</th>
                    <th>Jornada</th>
                    <th>Área</th>
                    <th>Centro de Formación</th>
                    <th>Fecha límite</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td><strong>#{{ $course->id }}</strong></td>
                        <td><span class="badge bg-secondary">{{ $course->course_number }}</span></td>
                        <td>{{ $course->name ?? '—' }}</td>
                        <td>{{ $course->day }}</td>
                        <td>{{ $course->area->name ?? 'Sin área' }}</td>
                        <td>{{ $course->trainingCenter->name ?? 'Sin centro' }}</td>
                        <td>
                            @if ($course->deadline)
                                @if ($course->deadline->lt(\Illuminate\Support\Carbon::today()))
                                    <span class="badge bg-danger">{{ $course->deadline->format('d/m/Y') }}</span>
                                @else
                                    <span class="badge bg-success">{{ $course->deadline->format('d/m/Y') }}</span>
                                @endif
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline-block">
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
                        <td colspan="8" class="text-center text-muted py-4">No hay cursos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
