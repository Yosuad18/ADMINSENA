@extends('layouts.public')

@section('title', 'Noticias')

@section('content')

    <section class="page-head" aria-labelledby="page-title">
        <div class="container">
            <p class="eyebrow">Sala de prensa</p>
            <h1 id="page-title" class="page-head__title">Noticias</h1>
            <p class="page-head__lead">Convocatorias, alianzas y logros de la comunidad formativa.</p>
        </div>
    </section>

    <section class="container section" aria-label="Listado de noticias">
        <div class="news-list">
            @foreach ($news as $article)
                <article class="news-row sena-card-hover">
                    <div class="news-row__date" aria-hidden="true">
                        <span class="news-row__day">{{ \Illuminate\Support\Carbon::parse($article['date'])->day }}</span>
                        <span class="news-row__month">{{ \Illuminate\Support\Carbon::parse($article['date'])->locale('es')->translatedFormat('M') }}</span>
                    </div>
                    <div class="news-row__body">
                        <p class="news-card__meta">
                            <span class="badge">{{ $article['category'] }}</span>
                            <time datetime="{{ $article['date'] }}">{{ \Illuminate\Support\Carbon::parse($article['date'])->isoFormat('D [de] MMMM [de] YYYY') }}</time>
                        </p>
                        <h2 class="news-row__title">
                            <a href="{{ route('news.show', $article['slug']) }}">{{ $article['title'] }}</a>
                        </h2>
                        <p class="news-card__excerpt">{{ $article['excerpt'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

@endsection
