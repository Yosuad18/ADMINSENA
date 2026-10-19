@extends('layouts.app')

@section('content')
<style>
    .admin-shell {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    .admin-bar {
        background: #ffffff;
        border-top: 4px solid #39A900;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 1rem;
        overflow: hidden;
    }

    .admin-bar__head {
        background-color: #00324D;
        color: #ffffff;
        padding: 0.9rem 1rem;
        font-weight: 600;
    }

    .admin-bar__scroll {
        max-height: calc(100vh - 220px);
        overflow-y: auto;
        padding: 0.5rem;
    }

    .admin-bar__link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0.9rem;
        border-radius: 0.5rem;
        color: #333333;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .admin-bar__link:hover,
    .admin-bar__link.is-active {
        background-color: #39A900;
        color: #ffffff;
    }

    .admin-bar__link i {
        width: 20px;
        text-align: center;
    }

    .admin-bar__link .badge {
        margin-left: auto;
    }

    .admin-card {
        background: #ffffff;
        border: none;
        border-top: 4px solid #39A900;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .admin-card__icon {
        width: 48px;
        height: 48px;
        border-radius: 0.75rem;
        background-color: rgba(57, 169, 0, 0.12);
        color: #39A900;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .api-status {
        font-size: 0.85rem;
    }

    @media (max-width: 991.98px) {
        .admin-shell {
            grid-template-columns: 1fr;
        }

        .admin-bar {
            position: static;
        }

        .admin-bar__scroll {
            max-height: 260px;
        }
    }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
        <h2 class="mb-1">Panel de administración</h2>
        <p class="text-muted mb-0">Selecciona una tabla para abrir su índice y modificar sus registros.</p>
    </div>
    <span class="api-status badge {{ $online ? 'bg-success' : 'bg-secondary' }} p-2">
        <i class="fas {{ $online ? 'fa-link' : 'fa-plug-circle-xmark' }} me-1"></i>
        API del cliente: {{ $online ? 'conectada' : 'no disponible' }} ({{ $apiUrl }})
    </span>
</div>

<div class="admin-shell">
    <aside class="admin-bar" aria-label="Tablas disponibles">
        <div class="admin-bar__head">
            <i class="fas fa-table me-2"></i> Tablas
        </div>
        <div class="admin-bar__scroll">
            @foreach ($tables as $table)
                <a class="admin-bar__link {{ request()->routeIs($table['route']) ? 'is-active' : '' }}"
                   href="{{ route($table['route']) }}">
                    <i class="fas {{ $table['icon'] }}"></i>
                    <span>{{ $table['label'] }}</span>
                    <span class="badge bg-secondary rounded-pill">{{ $table['count'] }}</span>
                </a>
            @endforeach
        </div>
    </aside>

    <section>
        <div class="row g-3">
            @foreach ($tables as $table)
                <div class="col-md-6 col-xl-4">
                    <div class="card admin-card">
                        <div class="card-body d-flex flex-column gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="admin-card__icon">
                                    <i class="fas {{ $table['icon'] }}"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $table['label'] }}</h6>
                                    <small class="text-muted">{{ $table['count'] }} registros · {{ $table['endpoint'] }}</small>
                                </div>
                            </div>
                            <a href="{{ route($table['route']) }}" class="btn btn-sena mt-2">
                                <i class="fas fa-list me-1"></i> Ver índice
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
