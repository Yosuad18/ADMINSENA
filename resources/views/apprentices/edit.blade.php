@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-sena p-4">
            <h3 class="fw-bold mb-4" style="color: var(--sena-dark);">
                <i class="fas fa-user-edit text-success me-2"></i>Editar Aprendiz
            </h3>

            <form action="{{ route('apprentices.update', $apprentice) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre Completo</label>
                    <input type="text" name="name" value="{{ $apprentice->name }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ $apprentice->email }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Teléfono Celular</label>
                    <input type="text" name="cell_number" value="{{ $apprentice->cell_number }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Curso / Ficha</label>
                    <select name="course_id" class="form-select" required>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $apprentice->course_id == $course->id ? 'selected' : '' }}>
                                {{ $course->course_number }} - {{ $course->day }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Computador Asignado (Opcional)</label>
                    <select name="computer_id" class="form-select">
                        <option value="">Sin equipo asignado</option>
                        @foreach($computers as $computer)
                            <option value="{{ $computer->id }}" {{ $apprentice->computer_id == $computer->id ? 'selected' : '' }}>
                                {{ $computer->brand }} (S/N: {{ $computer->serial_number }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('apprentices.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-sena">
                        <i class="fas fa-sync-alt me-1"></i> Actualizar Aprendiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
