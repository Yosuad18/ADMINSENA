@extends('layouts.public')

@section('title', 'Acceso institucional')

@section('content')

    <section class="login-section" aria-labelledby="login-title">
        <div class="container container--narrow">
            <div class="login-card sena-glow-focus">
                <header class="login-card__head">
                    <img src="{{ asset('images/Sena2.jpg') }}" alt="" width="56" height="56">
                    <h1 id="login-title">Acceso institucional</h1>
                    <p>Panel administrativo — uso exclusivo del personal autorizado.</p>
                </header>

                @error('auth')
                    <p class="flash flash--error" role="alert">{{ $message }}</p>
                @enderror

                <form action="{{ route('login.attempt') }}" method="POST" novalidate>
                    @csrf

                    <div class="form-field">
                        <label for="lg-email">Correo institucional</label>
                        <input id="lg-email" name="email" type="email" required
                               value="{{ old('email') }}" autocomplete="username" autofocus>
                        @error('email')<p class="field-error" role="alert">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-field">
                        <label for="lg-password">Contraseña</label>
                        <input id="lg-password" name="password" type="password" required
                               autocomplete="current-password">
                        @error('password')<p class="field-error" role="alert">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-check">
                        <input id="lg-remember" name="remember" type="checkbox" value="1">
                        <label for="lg-remember">Mantener la sesión abierta</label>
                    </div>

                    <button type="submit" class="btn btn--primary btn--lg btn--block">Ingresar al panel</button>
                </form>

                <footer class="login-card__foot">
                    <a href="{{ route('home') }}">← Volver al sitio público</a>
                </footer>
            </div>
        </div>
    </section>

@endsection
