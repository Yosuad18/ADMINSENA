<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENA - Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --sena-green: #39A900;
            --sena-dark: #00324D;
            --sena-black: #1E1E1E;
        }

        body {
            background-color: #f4f6f9;
            color: #333333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header / Navbar */
        .sena-header {
            background-color: #ffffff;
            border-bottom: 4px solid var(--sena-green);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .navbar-dark-sena {
            background-color: var(--sena-dark);
        }

        .navbar-dark-sena .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            padding: 0.8rem 1.2rem;
            transition: background-color 0.2s ease;
        }

        .navbar-dark-sena .nav-link:hover,
        .navbar-dark-sena .nav-link.active {
            background-color: var(--sena-green);
        }

        /* Componentes / Tarjetas */
        .card-sena {
            border: none;
            border-top: 4px solid var(--sena-green);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            background-color: #ffffff;
        }

        .btn-sena {
            background-color: var(--sena-green);
            color: #ffffff;
            font-weight: 600;
            border: none;
        }

        .btn-sena:hover {
            background-color: #2e8800;
            color: #ffffff;
        }

        .btn-sena-dark {
            background-color: var(--sena-dark);
            color: #ffffff;
            font-weight: 600;
            border: none;
        }

        .btn-sena-dark:hover {
            background-color: #002235;
            color: #ffffff;
        }

        /* Tablas */
        .table-sena thead {
            background-color: var(--sena-dark);
            color: #ffffff;
        }

        /* Footer */
        .sena-footer {
            background-color: var(--sena-black);
            color: #ffffff;
            margin-top: auto;
            border-top: 4px solid var(--sena-green);
        }
    </style>
</head>
<body>

    <header class="sena-header py-2">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('images/Sena.png') }}" alt="Logo SENA" width="70">
                <div>
                    <h1 class="h4 mb-0 fw-bold" style="color: var(--sena-dark);">Servicio Nacional de Aprendizaje</h1>
                    <small class="text-muted fw-semibold">Sistema de Gestión Institucional</small>
                </div>
            </div>
            <span class="badge bg-success p-2 fs-6 d-none d-md-inline-block">
                <i class="fas fa-check-circle me-1"></i> Sistema Activo
            </span>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark-sena p-0">
        <div class="container">
            <button class="navbar-toggler my-2" type="button" data-bs-toggle="collapse" data-bs-target="#senaNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="senaNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">
                            <i class="fas fa-book-open me-1"></i> Cursos / Fichas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('apprentices.*') ? 'active' : '' }}" href="{{ route('apprentices.index') }}">
                            <i class="fas fa-user-graduate me-1"></i> Aprendices
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        @yield('content')
    </main>

    <footer class="sena-footer py-4">
        <div class="container">
            <div class="row gy-3">
                <div class="col-md-6">
                    <h5 class="fw-bold text-success mb-2">Servicio Nacional de Aprendizaje - SENA</h5>
                    <p class="small text-secondary mb-0">
                        Dirección General: Calle 57 No. 8 - 69 Bogotá D.C. - Colombia<br>
                        Línea gratuita nacional: 01 8000 910270
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="small text-secondary mb-0">
                        &copy; {{ date('Y') }} SENA - Todos los derechos reservados.<br>
                        Panel Administrativo Interno
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.bundle.min.js"></script>
</body>
</html>
