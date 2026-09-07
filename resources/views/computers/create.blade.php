@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-sena p-4">
            <h3 class="fw-bold mb-4" style="color: var(--sena-dark);">
                <i class="fas fa-plus-circle text-success me-2"></i>Registrar Equipo
            </h3>

            <form action="{{ route('computers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Marca</label>
                    <input type="text" name="brand" class="form-control" placeholder="Ej. Dell, HP, Lenovo" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Número Serial</label>
                    <input type="text" name="number" class="form-control" placeholder="Ej. SN-2024-001" required>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('computers.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-sena">
                        <i class="fas fa-save me-1"></i> Guardar Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
