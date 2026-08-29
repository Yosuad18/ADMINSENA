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
                    <label class="form-label fw-bold">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $apprentice->name) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Apellido</label>
                    <input type="text" name="surname" value="{{ old('surname', $apprentice->surname) }}" class="form-control">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Cédula / Tarjeta de identidad</label>
                        <input type="text" name="document" value="{{ old('document', $apprentice->document) }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Estrato social</label>
                        <select name="estrato" class="form-select">
                            <option value="">Seleccione…</option>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ old('estrato', $apprentice->estrato) == $i ? 'selected' : '' }}>Estrato {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Dirección de residencia</label>
                    <input type="text" name="address" value="{{ old('address', $apprentice->address) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ old('email', $apprentice->email) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Celular</label>
                    <input type="text" name="cell_number" value="{{ old('cell_number', $apprentice->cell) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Curso / Ficha</label>
                    <select name="course_id" class="form-select" required>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $apprentice->course_id) == $course->id ? 'selected' : '' }}>
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
                            <option value="{{ $computer->id }}" {{ old('computer_id', $apprentice->computer_id) == $computer->id ? 'selected' : '' }}>
                                {{ $computer->brand }} (N°: {{ $computer->number }})
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