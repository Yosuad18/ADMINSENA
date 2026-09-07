@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-sena p-4">
            <h3 class="fw-bold mb-4" style="color: var(--sena-dark);">
                <i class="fas fa-plus-circle text-success me-2"></i>Crear Nuevo Curso
            </h3>

            <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Número de Curso / Ficha</label>
                    <input type="text" name="course_number" class="form-control" placeholder="Ej. 2670123" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre del Programa (público)</label>
                    <input type="text" name="name" class="form-control" placeholder="Ej. Análisis y Desarrollo de Software">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jornada / Días</label>
                        <input type="text" name="day" class="form-control" placeholder="Ej. Diurna - Lunes a Viernes" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Fecha límite de inscripción</label>
                        <input type="date" name="deadline" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Imagen del Curso</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
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
                    <label class="form-label fw-bold d-block">Instructores Asignados</label>
                    @foreach($teachers as $teacher)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="teachers[]" value="{{ $teacher->id }}" id="t_{{ $teacher->id }}">
                            <label class="form-check-label" for="t_{{ $teacher->id }}">{{ $teacher->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-sena">
                        <i class="fas fa-save me-1"></i> Guardar Curso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
