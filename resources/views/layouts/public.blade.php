<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ config('site.app.description') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="chat-endpoint" content="{{ route('chat.send') }}">

    <title>@yield('title', config('site.app.name')) — {{ config('site.app.name') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
</head>
<body>
    <a class="skip-link" href="#contenido">Saltar al contenido principal</a>

    <header class="site-header" role="banner">
        <div class="container site-header__inner">

            <a href="{{ route('home') }}" class="brand" aria-label="{{ config('site.app.full_name') }} — inicio">
                <img src="{{ asset('images/Sena2.png') }}" alt="" width="70" height="150" class="brand__logo">
                <span class="brand__text">
                    <strong class="brand__name">{{ config('site.app.name') }}</strong>
                    <span class="brand__tagline">{{ config('site.app.tagline') }}</span>
                </span>
            </a>

            <form class="header-search" role="search" action="{{ route('search') }}" method="GET">
                <label class="visually-hidden" for="header-search-input">Buscar en el sitio</label>
                <input id="header-search-input"
                       type="search"
                       name="q"
                       placeholder="Buscar programas, noticias…"
                       value="{{ request('q') }}"
                       autocomplete="off">
                <button type="submit" aria-label="Buscar">
                    <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" focusable="false">
                        <circle cx="10.5" cy="10.5" r="6.5" fill="none" stroke="currentColor" stroke-width="2.4"/>
                        <line x1="15.5" y1="15.5" x2="21" y2="21" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                    </svg>
                </button>
            </form>

            <button class="nav-toggle" type="button"
                    aria-expanded="false"
                    aria-controls="primary-nav"
                    data-nav-toggle>
                <span class="nav-toggle__bar" aria-hidden="true"></span>
                <span class="nav-toggle__bar" aria-hidden="true"></span>
                <span class="nav-toggle__bar" aria-hidden="true"></span>
                <span class="visually-hidden">Abrir o cerrar el menú de navegación</span>
            </button>

            <nav class="primary-nav" id="primary-nav" aria-label="Navegación principal" data-nav>
                <ul class="primary-nav__list">
                    <li><a href="{{ route('home') }}"      class="primary-nav__link {{ request()->routeIs('home') ? 'is-active' : '' }}">Inicio</a></li>
                    <li><a href="{{ route('about') }}"     class="primary-nav__link {{ request()->routeIs('about') ? 'is-active' : '' }}">Quiénes somos</a></li>
                    <li><a href="{{ route('programs') }}"  class="primary-nav__link {{ request()->routeIs('programs') ? 'is-active' : '' }}">Programas</a></li>
                    <li><a href="{{ route('news.index') }}" class="primary-nav__link {{ request()->routeIs('news.*') ? 'is-active' : '' }}">Noticias</a></li>
                    <li><a href="{{ route('events') }}"    class="primary-nav__link {{ request()->routeIs('events') ? 'is-active' : '' }}">Eventos</a></li>
                    <li><a href="{{ route('contact') }}"   class="primary-nav__link {{ request()->routeIs('contact') ? 'is-active' : '' }}">Contacto</a></li>
                </ul>

                <div class="primary-nav__actions">
                    @auth
                        <a href="{{ route('admin.panel') }}" class="btn btn--light">Administración</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn--light">Ingresar</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main id="contenido" class="site-main" role="main">
        @if (session('success'))
            <div class="container" role="status">
                <p class="flash flash--success">
                    <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false">
                        <circle cx="12" cy="12" r="10" fill="currentColor"/>
                        <path d="M7 12.5l3.2 3.2L17 9" fill="none" stroke="#fff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer" role="contentinfo">
        <div class="container site-footer__grid">
            <section aria-label="Identificación institucional">
                <h2 class="site-footer__heading">{{ config('site.app.full_name') }}</h2>
                <p class="site-footer__text">
                    {{ config('site.contact.address') }}<br>
                    Línea gratuita nacional: {{ config('site.contact.phone') }}
                </p>
            </section>

            <nav aria-label="Enlaces del sitio">
                <h2 class="site-footer__heading">Sitio</h2>
                <ul class="site-footer__links">
                    <li><a href="{{ route('about') }}">Quiénes somos</a></li>
                    <li><a href="{{ route('programs') }}">Programas</a></li>
                    <li><a href="{{ route('news.index') }}">Noticias</a></li>
                    <li><a href="{{ route('events') }}">Eventos</a></li>
                </ul>
            </nav>

            <section aria-label="Atención al ciudadano">
                <h2 class="site-footer__heading">Atención</h2>
                <p class="site-footer__text">
                    {{ config('site.contact.email') }}<br>
                    {{ config('site.contact.schedule') }}
                </p>
            </section>
        </div>

        <div class="container site-footer__legal">
            <p>&copy; {{ date('Y') }} {{ config('site.app.name') }} — Todos los derechos reservados.</p>
        </div>
    </footer>

    @include('public.partials.chat-widget')

    <script src="{{ asset('js/public.js') }}" defer></script>
</body>
</html>
