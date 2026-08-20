@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-sena p-4">
            <h3 class="fw-bold mb-4" style="color: var(--sena-dark);">
                <i class="fas fa-user-plus text-success me-2"></i>Registrar Aprendiz
            </h3>

            <form action="{{ route('apprentices.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre Completo</label>
                    <input type="text" name="name" class="form-control" placeholder="Ej. Juan Pérez" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Curso / Ficha</label>
                    <select name="course_id" class="form-select" required>
                        <option value="">Seleccione un curso...</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_number }} - {{ $course->day }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Computador Asignado (Opcional)</label>
                    <select name="computer_id" class="form-select">
                        <option value="">Sin equipo asignado</option>
                        @foreach($computers as $computer)
                            <option value="{{ $computer->id }}">{{ $computer->brand }} (S/N: {{ $computer->serial_number }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('apprentices.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-sena">
                        <i class="fas fa-save me-1"></i> Guardar Aprendiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
