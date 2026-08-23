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

    <section class="container section" aria-label="Catálogo de programas">
        <div class="program-grid">
            @foreach ($programs as $program)
                <article class="catalog-card sena-card-hover" style="--accent: {{ $program['accent'] }}">
                    <figure class="catalog-card__media">
                        <img src="{{ asset($program['image']) }}" alt="" width="400" height="280" loading="lazy">
                        <figcaption class="visually-hidden">{{ $program['name'] }}</figcaption>
                    </figure>

                    <div class="catalog-card__body">
                        <p class="catalog-card__code">{{ $program['code'] }}</p>
                        <h2 class="catalog-card__name">{{ $program['name'] }}</h2>
                        <p class="catalog-card__summary">{{ $program['summary'] }}</p>

                        <dl class="catalog-card__specs">
                            <div><dt>Duración</dt><dd>{{ $program['duration'] }}</dd></div>
                            <div><dt>Modalidad</dt><dd>{{ $program['modality'] }}</dd></div>
                        </dl>

                        <ul class="tag-list" aria-label="Áreas de competencia">
                            @foreach (array_slice($program['tags'], 0, 3) as $tag)
                                <li>{{ $tag }}</li>
                            @endforeach
                        </ul>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

@endsection
