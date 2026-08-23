@extends('layouts.public')

@section('title', $article['title'])

@section('content')

    <article class="article">
        <header class="page-head page-head--narrow" aria-labelledby="article-title">
            <div class="container">
                <p class="eyebrow">{{ $article['category'] }}</p>
                <h1 id="article-title" class="page-head__title page-head__title--article">{{ $article['title'] }}</h1>
                <p class="article__meta">
                    Publicada el
                    <time datetime="{{ $article['date'] }}">{{ \Illuminate\Support\Carbon::parse($article['date'])->isoFormat('D [de] MMMM [de] YYYY') }}</time>
                </p>
            </div>
        </header>

        <div class="container container--narrow section">
            @foreach ($article['body'] as $paragraph)
                <p class="article__paragraph">{{ $paragraph }}</p>
            @endforeach

            <footer class="article__footer">
                <a href="{{ route('news.index') }}" class="btn btn--outline">← Volver a noticias</a>
            </footer>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <aside class="related fade-in-section" aria-labelledby="related-title">
            <div class="container">
                <h2 id="related-title" class="section-title">Sigue leyendo</h2>
                <div class="card-grid card-grid--2">
                    @foreach ($related as $item)
                        <article class="news-card sena-card-hover">
                            <p class="news-card__meta">
                                <span class="badge">{{ $item['category'] }}</span>
                                <time datetime="{{ $item['date'] }}">{{ \Illuminate\Support\Carbon::parse($item['date'])->isoFormat('D [de] MMMM YYYY') }}</time>
                            </p>
                            <h3 class="news-card__title">
                                <a href="{{ route('news.show', $item['slug']) }}">{{ $item['title'] }}</a>
                            </h3>
                            <p class="news-card__excerpt">{{ $item['excerpt'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </aside>
    @endif

@endsection
