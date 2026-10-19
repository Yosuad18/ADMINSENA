@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-sena p-4">
            <h3 class="fw-bold mb-4" style="color: var(--sena-dark);">
                <i class="fas fa-user-shield text-success me-2"></i>Editar Administrador
            </h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admins.update', $admin) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nombre</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $admin->name) }}" class="form-control" required>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-sena">
                        <i class="fas fa-save me-1"></i> Actualizar Administrador
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
