@extends('layouts.public')

@section('title', 'Contacto')

@section('content')

    <section class="page-head" aria-labelledby="page-title">
        <div class="container">
            <p class="eyebrow">Atención al ciudadano</p>
            <h1 id="page-title" class="page-head__title">Contacto</h1>
            <p class="page-head__lead">
                Escríbenos y recibe respuesta en un máximo de dos días hábiles.
            </p>
        </div>
    </section>

    <section class="container section split split--contact" aria-label="Formulario y canales de contacto">

        <form class="contact-form sena-glow-focus" action="{{ route('contact.submit') }}" method="POST" novalidate>
            @csrf

            <div class="form-row">
                <div class="form-field">
                    <label for="ct-name">Nombre completo</label>
                    <input id="ct-name" name="name" type="text" required value="{{ old('name') }}" autocomplete="name">
                    @error('name')<p class="field-error" role="alert">{{ $message }}</p>@enderror
                </div>

                <div class="form-field">
                    <label for="ct-email">Correo electrónico</label>
                    <input id="ct-email" name="email" type="email" required value="{{ old('email') }}" autocomplete="email">
                    @error('email')<p class="field-error" role="alert">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-field">
                <label for="ct-subject">Asunto</label>
                <input id="ct-subject" name="subject" type="text" required value="{{ old('subject') }}">
                @error('subject')<p class="field-error" role="alert">{{ $message }}</p>@enderror
            </div>

            <div class="form-field">
                <label for="ct-message">Mensaje</label>
                <textarea id="ct-message" name="message" rows="6" required minlength="20"
                          aria-describedby="ct-message-hint">{{ old('message') }}</textarea>
                <p class="field-hint" id="ct-message-hint">Mínimo 20 caracteres. Sé específico para agilizar tu respuesta.</p>
                @error('message')<p class="field-error" role="alert">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn btn--primary btn--lg btn-pulse">Enviar mensaje</button>
        </form>

        <aside class="contact-channels" aria-label="Otros canales de atención">
            <h2>Otros canales</h2>

            <ul class="channel-list">
                <li>
                    <span class="channel-list__icon" aria-hidden="true">☎</span>
                    <div><strong>Línea gratuita nacional</strong><br>{{ config('site.contact.phone') }}</div>
                </li>
                <li>
                    <span class="channel-list__icon" aria-hidden="true">✉</span>
                    <div><strong>Correo institucional</strong><br>{{ config('site.contact.email') }}</div>
                </li>
                <li>
                    <span class="channel-list__icon" aria-hidden="true">⌂</span>
                    <div><strong>Sede principal</strong><br>{{ config('site.contact.address') }}</div>
                </li>
                <li>
                    <span class="channel-list__icon" aria-hidden="true">◷</span>
                    <div><strong>Horario de atención</strong><br>{{ config('site.contact.schedule') }}</div>
                </li>
            </ul>
        </aside>
    </section>

@endsection
