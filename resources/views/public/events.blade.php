@extends('layouts.public')

@section('title', 'Eventos')

@section('content')

    <section class="page-head" aria-labelledby="page-title">
        <div class="container">
            <p class="eyebrow">Agenda institucional</p>
            <h1 id="page-title" class="page-head__title">Eventos</h1>
            <p class="page-head__lead">
                Jornadas de inscripción, ferias, competencias y ceremonias abiertas al público.
            </p>
        </div>
    </section>

    <section class="container section" aria-label="Agenda de eventos">
        <ol class="timeline">
            @foreach ($events as $event)
                <li class="timeline__item sena-glow-focus">
                    <div class="event-date-chip event-date-chip--boxed" aria-hidden="true">
                        <span class="event-date-chip__day">{{ \Illuminate\Support\Carbon::parse($event['date'])->day }}</span>
                        <span class="event-date-chip__month">{{ \Illuminate\Support\Carbon::parse($event['date'])->locale('es')->translatedFormat('M') }}</span>
                    </div>

                    <div class="timeline__content">
                        <p class="badge badge--soft">{{ $event['type'] }}</p>
                        <h2 class="timeline__title">{{ $event['title'] }}</h2>
                        <p class="timeline__detail">{{ $event['detail'] }}</p>

                        <ul class="event-meta">
                            <li>
                                <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3.5 2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                {{ $event['time'] }}
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false"><path d="M12 21s-7-6.1-7-11a7 7 0 1 1 14 0c0 4.9-7 11-7 11z" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="10" r="2.6" fill="none" stroke="currentColor" stroke-width="2"/></svg>
                                {{ $event['place'] }}
                            </li>
                        </ul>
                    </div>
                </li>
            @endforeach
        </ol>
    </section>

@endsection
