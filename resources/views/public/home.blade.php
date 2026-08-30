@extends('layouts.public')

@section('title', 'Inicio')

@section('content')

    <section class="hero" aria-labelledby="hero-title">
        <div class="container hero__inner">
            <p class="hero__kicker">Formación técnica y tecnológica · Gratuita</p>
            <h1 id="hero-title" class="hero__title">
                Aprende la profesión que <em>Colombia</em> necesita
            </h1>
            <p class="hero__lead">
                Explora programas de tecnología con certificación oficial,
                inscríbete a eventos abiertos y mantente al día con la agenda institucional.
            </p>
            <div class="hero__actions">
                <a href="{{ route('programs') }}" class="btn btn--primary btn--lg">Explorar programas</a>
                <a href="{{ route('events') }}" class="btn btn--ghost btn--lg">Ver agenda de eventos</a>
            </div>

            <dl class="hero__stats">
                <div><dt>{{ count(config('site.programs')) }}</dt><dd>Programas de tecnología</dd></div>
                <div><dt>33</dt><dd>Centros de formación</dd></div>
                <div><dt>100%</dt><dd>Formación gratuita</dd></div>
            </dl>
        </div>
    </section>

    <section class="ribbon-section" aria-labelledby="ribbon-title">
        <h2 id="ribbon-title" class="visually-hidden">Programas de tecnología destacados</h2>

        <div class="ribbon" data-ribbon tabindex="0" aria-label="Carrusel de programas. Usa las teclas para pausar o reanudar.">
            @foreach ([0 => false, 1 => true] as $copy => $isClone)
                <ul class="ribbon__track {{ $isClone ? 'ribbon__track--clone' : '' }}" aria-hidden="{{ $isClone ? 'true' : 'false' }}">
                    @foreach ($programs as $program)
                        <li class="ribbon__item">
                            <article class="program-card">
                                <br>
                                <br>
                                <figure class="program-card__media">
                                    <img src="{{ asset($program['image']) }}"
                                         alt="" width="400" height="280"
                                         loading="{{ $copy === 0 ? 'eager' : 'lazy' }}">
                                </figure>
                                <div class="program-card__body">
                                    <span class="program-card__code" style="--accent: {{ $program['accent'] }}">
                                        {{ $program['code'] }}
                                    </span>
                                    <h3 class="program-card__name">{{ $program['name'] }}</h3>
                                    <p class="program-card__meta">{{ $program['level'] }} · {{ $program['duration'] }}</p>
                                </div>
                            </article>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>

        <p class="container ribbon-hint">
            <a href="{{ route('programs') }}">Ver todos los programas →</a>
        </p>
    </section>


    <br>
    <section class="about-teaser fade-in-section" aria-labelledby="about-teaser-title">
        <div class="container split">
            <div>
                <h2 id="about-teaser-title" class="section-title">Educación pública que transforma regiones</h2>
                <p class="section-text">
                    Desde 1957 formamos técnicos, tecnólogos y emprendedores en todos los rincones
                    del país. Nuestra formación es gratuita, pertinente al sector productivo
                    y certificada bajo estándares nacionales e internacionales.
                </p>
                <a href="{{ route('about') }}" class="btn btn--outline">Conoce nuestra historia</a>
            </div>
            <aside class="fact-stack" aria-label="Datos institucionales">
                <article class="fact"><span class="fact__value">+8M</span><span class="fact__label">Aprendices formados</span></article>
                <article class="fact"><span class="fact__value">100+</span><span class="fact__label">Programas activos</span></article>
                <article class="fact"><span class="fact__value">32</span><span class="fact__label">Departamentos cubiertos</span></article>
            </aside>
        </div>
    </section>

    <section class="news-preview fade-in-section" aria-labelledby="news-preview-title">
        <div class="container">
            <header class="section-head">
                <h2 id="news-preview-title" class="section-title">Últimas noticias</h2>
                <a href="{{ route('news.index') }}" class="see-all">Todas las noticias →</a>
            </header>

            <div class="card-grid card-grid--3">
                @foreach ($latestNews as $article)
                    <article class="news-card sena-card-hover">
                        <p class="news-card__meta">
                            <span class="badge">{{ $article['category'] }}</span>
                            <time datetime="{{ $article['date'] }}">{{ \Illuminate\Support\Carbon::parse($article['date'])->isoFormat('D [de] MMMM YYYY') }}</time>
                        </p>
                        <h3 class="news-card__title">
                            <a href="{{ route('news.show', $article['slug']) }}">{{ $article['title'] }}</a>
                        </h3>
                        <p class="news-card__excerpt">{{ $article['excerpt'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @if ($upcomingEvent)
        <section class="event-spotlight fade-in-section" aria-labelledby="event-spotlight-title">
            <div class="container event-spotlight__inner">
                <div class="event-date-chip" aria-hidden="true">
                    <span class="event-date-chip__day">{{ \Illuminate\Support\Carbon::parse($upcomingEvent['date'])->day }}</span>
                    <span class="event-date-chip__month">{{ \Illuminate\Support\Carbon::parse($upcomingEvent['date'])->locale('es')->translatedFormat('M') }}</span>
                </div>
                <div>
                    <p class="eyebrow eyebrow--light">Próximo evento · {{ $upcomingEvent['type'] }}</p>
                    <h2 id="event-spotlight-title">{{ $upcomingEvent['title'] }}</h2>
                    <p>{{ $upcomingEvent['place'] }} — {{ $upcomingEvent['time'] }}</p>
                </div>
                <a href="{{ route('events') }}" class="btn btn--light">Agenda completa</a>
            </div>
        </section>
    @endif

@endsection
