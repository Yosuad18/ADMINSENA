@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-sena p-4">
            <h3 class="fw-bold mb-4" style="color: var(--sena-dark);">
                <i class="fas fa-edit text-success me-2"></i>Editar Equipo
            </h3>

            <form action="{{ route('computers.update', $computer) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-bold">Marca</label>
                    <input type="text" name="brand" class="form-control" value="{{ old('brand', $computer->brand) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Número Serial</label>
                    <input type="text" name="number" class="form-control" value="{{ old('number', $computer->number) }}" required>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('computers.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-sena">
                        <i class="fas fa-save me-1"></i> Actualizar Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
