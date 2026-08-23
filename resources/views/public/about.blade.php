@extends('layouts.public')

@section('title', 'Quiénes somos')

@section('content')

    <section class="page-head" aria-labelledby="page-title">
        <div class="container">
            <p class="eyebrow">Institución</p>
            <h1 id="page-title" class="page-head__title">Quiénes somos</h1>
            <p class="page-head__lead">
                El Servicio Nacional de Aprendizaje es la entidad del Estado colombiano
                encargada de la formación técnica y tecnológica gratuita para el trabajo.
            </p>
        </div>
    </section>

    <section class="container section" aria-label="Misión y visión">
        <div class="split split--cards">
            <article class="mission-card sena-card-hover">
                <h2>Misión</h2>
                <p>
                    Formar ciudadanos con capacidades técnicas y valores éticos, contribuyendo al
                    desarrollo económico, social y tecnológico del país mediante formación profesional
                    integral gratuita, pertinente y de calidad.
                </p>
            </article>
            <article class="mission-card mission-card--dark sena-card-hover">
                <h2>Visión</h2>
                <p>
                    Ser la institución de formación para el trabajo referente en América Latina,
                    reconocida por la innovación de sus metodologías, la pertinencia de su oferta
                    y el impacto de sus egresados en las regiones.
                </p>
            </article>
        </div>
    </section>

    <section class="values fade-in-section" aria-labelledby="values-title">
        <div class="container">
            <h2 id="values-title" class="section-title">Nuestros principios</h2>
            <ul class="values__grid">
                <li><strong>Gratuidad</strong><span>La educación pública técnica es un derecho, no un privilegio.</span></li>
                <li><strong>Pertinencia</strong><span>Cada programa responde a las necesidades reales del sector productivo.</span></li>
                <li><strong>Integralidad</strong><span>Formamos competencias técnicas y ciudadanas en igual medida.</span></li>
                <li><strong>Innovación</strong><span>Ambientes de aprendizaje actualizados con tecnología de frontera.</span></li>
            </ul>
        </div>
    </section>

    <section class="stats-band fade-in-section" aria-label="Cifras institucionales">
        <div class="container stats-band__inner">
            <div><span class="stats-band__value">{{ $programCount }}</span><span class="stats-band__label">Tecnologías activas</span></div>
            <div><span class="stats-band__value">1957</span><span class="stats-band__label">Año de fundación</span></div>
            <div><span class="stats-band__value">33</span><span class="stats-band__label">Centros regionales</span></div>
            <div><span class="stats-band__value">116</span><span class="stats-band__label">Municipios con presencia</span></div>
        </div>
    </section>

@endsection
