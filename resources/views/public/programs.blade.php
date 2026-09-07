@extends('layouts.public')

@section('title', 'Programas de tecnología')

@section('content')

    <section class="page-head" aria-labelledby="page-title">
        <div class="container">
            <p class="eyebrow">Oferta académica</p>
            <h1 id="page-title" class="page-head__title">Programas de tecnología</h1>
            <p class="page-head__lead">
                Titulaciones de nivel tecnológico con certificación oficial.
                Todas las modalidades son gratuitas y cuentan con práctica productiva.
            </p>
        </div>
    </section>

    <section class="container section" aria-label="Filtros de programas">
        <div class="programs-toolbar">
            <div class="programs-toolbar__head">
                <h2 class="section-title">Explora por área</h2>
                <p class="programs-toolbar__count" aria-live="polite" data-results-count></p>
            </div>

            <div class="filter-chips" role="group" aria-label="Filtrar programas por área">
                <button type="button" class="filter-chip is-active" aria-pressed="true" data-area-filter="*">Todas</button>
                @foreach ($areas as $area)
                    <button type="button" class="filter-chip" aria-pressed="false" data-area-filter="{{ $area->name }}">{{ $area->name }}</button>
                @endforeach
            </div>
        </div>
    </section>

    @foreach ($locations as $location)
        <section class="container section location-section"
                 style="--accent: {{ $location['accent'] }}"
                 aria-labelledby="loc-{{ $location['slug'] }}"
                 data-location-section>

            <header class="location-section__head">
                <p class="eyebrow">Centro de formación</p>
                <h2 id="loc-{{ $location['slug'] }}" class="location-section__title">{{ $location['name'] }}</h2>
                <p class="location-section__blurb">{{ $location['blurb'] }}</p>
                <p class="location-section__count">{{ $location['programs']->count() }} programa(s) disponible(s)</p>
            </header>

            <div class="offer-grid">
                @foreach ($location['programs'] as $program)
                    <article class="offer-card sena-card-hover"
                             data-area="{{ $program->area->name }}"
                             data-deadline="{{ $program->deadline->toDateString() }}">

                        <figure class="offer-card__media">
                            @if ($program->image)
                                <img src="{{ asset('storage/images/' . $program->image) }}" alt="" width="400" height="280" loading="lazy">
                            @else
                                <span class="offer-card__media-placeholder" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" width="30" height="30" focusable="false">
                                        <rect x="2.5" y="5" width="19" height="14.5" rx="2.5" fill="none" stroke="currentColor" stroke-width="1.6"/>
                                        <circle cx="12" cy="12.5" r="3.4" fill="none" stroke="currentColor" stroke-width="1.6"/>
                                        <path d="M7 4.5l1.4-2h7.2l1.4 2" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="offer-card__media-note">Imagen próxima</span>
                                </span>
                            @endif
                            <figcaption class="visually-hidden">{{ $program->name }}</figcaption>
                        </figure>

                        <div class="offer-card__body">
                            <p class="offer-card__code">{{ $program->course_number }}</p>
                            <h3 class="offer-card__name">{{ $program->name }}</h3>

                            <ul class="offer-card__meta">
                                <li>
                                    <svg viewBox="0 0 24 24" width="15" height="15" focusable="false" aria-hidden="true">
                                        <path d="M12 21c-4.9-4.7-7.5-8.4-7.5-11.5A7.5 7.5 0 0 1 12 2a7.5 7.5 0 0 1 7.5 7.5c0 3.1-2.6 6.8-7.5 11.5Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                        <circle cx="12" cy="9.5" r="2.3" fill="none" stroke="currentColor" stroke-width="1.8"/>
                                    </svg>
                                    <span class="offer-card__location-dot" aria-hidden="true"></span>
                                    {{ $program->trainingCenter->name }}
                                </li>
                                <li>
                                    <svg viewBox="0 0 24 24" width="15" height="15" focusable="false" aria-hidden="true">
                                        <rect x="3" y="5" width="18" height="16" rx="2.5" fill="none" stroke="currentColor" stroke-width="1.8"/>
                                        <path d="M3 9.5h18M8 2.8V6m8-3.2V6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                    <span>Cierra · {{ $program->deadline->locale('es')->isoFormat('D MMM YYYY') }}</span>
                                </li>
                            </ul>

                            <p class="offer-card__area">
                                <span class="offer-card__area-tag">{{ $program->area->name }}</span>
                            </p>

                            <button type="button"
                                    class="btn btn-sena btn--block"
                                    data-register-open
                                    data-course-id="{{ $program->id }}"
                                    data-course-name="{{ $program->name }}">
                                Inscribirme
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endforeach

    <section class="container empty-state empty-state--filters" data-empty-state hidden>
        <h2>Sin resultados por el momento</h2>
        <p>No hay programas ofertados que coincidan con el área seleccionada. Prueba con otra área o vuelve más tarde.</p>
    </section>

    <div class="modal-backdrop" data-modal-backdrop hidden></div>

    <div class="modal" data-modal role="dialog"
         aria-modal="true"
         aria-labelledby="register-title"
         {{ $errors->any() ? 'data-open-on-error' : '' }}
         hidden>
        <div class="modal__panel">
            <header class="modal__head">
                <div>
                    <p class="eyebrow">Inscripción gratuita</p>
                    <h2 id="register-title" class="modal__title">Inscribirse al programa</h2>
                </div>
                <button type="button" class="modal__close" aria-label="Cerrar formulario de inscripción" data-modal-close>
                    <svg viewBox="0 0 24 24" width="22" height="22" focusable="false" aria-hidden="true">
                        <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                </button>
            </header>

            <p class="modal__program" data-register-course-name></p>

            <form method="POST" action="{{ route('programs.register') }}" class="contact-form" data-register-form>
                @csrf
                <input type="hidden" name="course_id" data-register-course-id value="{{ old('course_id') }}">

                <div class="form-row">
                    <div class="form-field">
                        <label for="reg-name">Nombre</label>
                        <input id="reg-name" name="name" value="{{ old('name') }}" required autocomplete="given-name">
                        @error('name')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-field">
                        <label for="reg-surname">Apellido</label>
                        <input id="reg-surname" name="surname" value="{{ old('surname') }}" required autocomplete="family-name">
                        @error('surname')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label for="reg-document">Cédula / Tarjeta de identidad</label>
                        <input id="reg-document" name="document" value="{{ old('document') }}" required inputmode="numeric" autocomplete="off">
                        @error('document')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-field">
                        <label for="reg-estrato">Estrato social</label>
                        <select id="reg-estrato" name="estrato" required>
                            <option value="" disabled {{ old('estrato') ? '' : 'selected' }}>Seleccione…</option>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ old('estrato') == $i ? 'selected' : '' }}>Estrato {{ $i }}</option>
                            @endfor
                        </select>
                        @error('estrato')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="form-field">
                    <label for="reg-address">Dirección de residencia</label>
                    <input id="reg-address" name="address" value="{{ old('address') }}" required autocomplete="street-address">
                    @error('address')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-field">
                    <label for="reg-email">Correo electrónico</label>
                    <input id="reg-email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                @if ($errors->has('course_id'))
                    <p class="field-error">{{ $errors->first('course_id') }}</p>
                @endif

                <button type="submit" class="btn btn-sena btn--block btn--lg">
                    Enviar inscripción
                </button>
            </form>
        </div>
    </div>

@endsection