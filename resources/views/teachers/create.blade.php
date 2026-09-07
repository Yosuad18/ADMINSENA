@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-sena p-4">
            <h3 class="fw-bold mb-4" style="color: var(--sena-dark);">
                <i class="fas fa-user-plus text-success me-2"></i>Registrar Instructor
            </h3>

            <form action="{{ route('teachers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre Completo</label>
                    <input type="text" name="name" class="form-control" placeholder="Ej. Juan Pérez" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" placeholder="Ej. juan@example.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Área</label>
                    <select name="area_id" class="form-select" required>
                        <option value="">Seleccione un área...</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Centro de Formación</label>
                    <select name="training_center_id" class="form-select" required>
                        <option value="">Seleccione un centro...</option>
                        @foreach($trainingCenters as $center)
                            <option value="{{ $center->id }}">{{ $center->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold d-block">Cursos Asignados</label>
                    @forelse($courses as $course)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="courses[]" value="{{ $course->id }}" id="c_{{ $course->id }}">
                            <label class="form-check-label" for="c_{{ $course->id }}">{{ $course->course_number }} - {{ $course->name ?? 'Sin nombre' }}</label>
                        </div>
                    @empty
                        <span class="text-muted">No hay cursos disponibles.</span>
                    @endforelse
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-sena">
                        <i class="fas fa-save me-1"></i> Guardar Instructor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
