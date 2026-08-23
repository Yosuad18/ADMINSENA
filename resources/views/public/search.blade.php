@extends('layouts.public')

@section('title', 'Resultados de búsqueda')

@section('content')

    <section class="page-head" aria-labelledby="page-title">
        <div class="container">
            <p class="eyebrow">Búsqueda</p>
            <h1 id="page-title" class="page-head__title">
                @if ($query !== '')
                    Resultados para “{{ $query }}”
                @else
                    Buscar
                @endif
            </h1>

            @if ($query !== '')
                <p class="page-head__lead">
                    {{ $total }} resultado{{ $total === 1 ? '' : 's' }} encontrado{{ $total === 1 ? '' : 's' }}
                    en programas, noticias y eventos.
                </p>
            @endif
        </div>
    </section>

    <section class="container section" aria-label="Resultados de búsqueda">

        @if ($query === '')
            <div class="empty-state">
                <h2>¿Qué estás buscando?</h2>
                <p>Usa el buscador del encabezado o prueba con términos como “software”, “inscripción” o “feria”.</p>
            </div>
        @elseif ($total === 0)
            <div class="empty-state">
                <h2>Sin coincidencias</h2>
                <p>No encontramos resultados para “{{ $query }}”. Revisa la ortografía o intenta con otra palabra.</p>
                <a href="{{ route('programs') }}" class="btn btn--outline">Explorar programas</a>
            </div>
        @else

            @if (count($results['programs']))
                <h2 class="results-group-title">Programas <span>({{ count($results['programs']) }})</span></h2>
                <ul class="result-list">
                    @foreach ($results['programs'] as $program)
                        <li class="result-item sena-card-hover">
                            <img src="{{ asset($program['image']) }}" alt="" width="72" height="52" loading="lazy">
                            <div>
                                <p class="badge badge--soft">{{ $program['level'] }}</p>
                                <h3><a href="{{ route('programs') }}">{{ $program['name'] }}</a></h3>
                                <p>{{ $program['summary'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if (count($results['news']))
                <h2 class="results-group-title">Noticias <span>({{ count($results['news']) }})</span></h2>
                <ul class="result-list">
                    @foreach ($results['news'] as $article)
                        <li class="result-item sena-card-hover">
                            <div class="result-item__date">{{ \Illuminate\Support\Carbon::parse($article['date'])->format('d/m') }}</div>
                            <div>
                                <p class="badge badge--soft">{{ $article['category'] }}</p>
                                <h3><a href="{{ route('news.show', $article['slug']) }}">{{ $article['title'] }}</a></h3>
                                <p>{{ $article['excerpt'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if (count($results['events']))
                <h2 class="results-group-title">Eventos <span>({{ count($results['events']) }})</span></h2>
                <ul class="result-list">
                    @foreach ($results['events'] as $event)
                        <li class="result-item sena-card-hover">
                            <div class="result-item__date">{{ \Illuminate\Support\Carbon::parse($event['date'])->format('d/m') }}</div>
                            <div>
                                <p class="badge badge--soft">{{ $event['type'] }}</p>
                                <h3><a href="{{ route('events') }}">{{ $event['title'] }}</a></h3>
                                <p>{{ $event['detail'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endif
    </section>

@endsection
