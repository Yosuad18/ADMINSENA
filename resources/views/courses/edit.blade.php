@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-sena p-4">
            <h3 class="fw-bold mb-4" style="color: var(--sena-dark);">
                <i class="fas fa-edit text-success me-2"></i>Editar Curso
            </h3>

            <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-bold">Número de Curso / Ficha</label>
                    <input type="text" name="course_number" class="form-control" value="{{ old('course_number', $course->course_number) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre del Programa (público)</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $course->name) }}" placeholder="Ej. Análisis y Desarrollo de Software">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jornada / Días</label>
                        <input type="text" name="day" class="form-control" value="{{ old('day', $course->day) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Fecha límite de inscripción</label>
                        <input type="date" name="deadline" class="form-control" value="{{ old('deadline', optional($course->deadline)->toDateString()) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Imagen del Curso</label>
                    @if($course->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/images/' . $course->image) }}" alt="Imagen actual" width="100" height="100" style="object-fit: cover; border-radius: 5px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Área</label>
                    <select name="area_id" class="form-select" required>
                        <option value="">Seleccione un área...</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ old('area_id', $course->area_id) == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Centro de Formación</label>
                    <select name="training_center_id" class="form-select" required>
                        <option value="">Seleccione un centro...</option>
                        @foreach($trainingCenters as $center)
                            <option value="{{ $center->id }}" {{ old('training_center_id', $course->training_center_id) == $center->id ? 'selected' : '' }}>
                                {{ $center->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold d-block">Instructores Asignados</label>
                    @foreach($teachers as $teacher)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="teachers[]" value="{{ $teacher->id }}"
                                id="t_{{ $teacher->id }}"
                                {{ in_array($teacher->id, old('teachers', $course->teachers->pluck('id')->toArray()), true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="t_{{ $teacher->id }}">{{ $teacher->name }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-sena">
                        <i class="fas fa-save me-1"></i> Actualizar Curso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection