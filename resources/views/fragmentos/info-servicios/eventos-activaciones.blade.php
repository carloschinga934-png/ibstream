@extends('layouts.layout')
@section('content')
{{-- priorizar el fondo negro --}}
@section("title", "Eventos | IBSTREAM")

    @push("styles")
        <link rel="stylesheet" href="{{ asset('css/animacion-servicios.css') }}">
        <style>
            body {
                background: #000 !important;
            }
        </style>

    @endpush
    <div class="container mt-5">
        <div class="row align-items-center" style="min-height: 60vh;padding-top: 60px;">
            <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
                <h2 class="fw-bold display-4 mb-3 anim-header" style="color: #fff; text-align: left; line-height: 1.1;">
                    Conecta con tu audiencia a través de <span style="color: #56FF00;">eventos</span> y <span
                        style="color: #56FF00;">experiencias únicas</span>
                </h2>
                <p class="fs-5 anim-header-delay" style="color: #fff; text-align: left; max-width: 400px;">
                    <span style="color: #56FF00;">Activa tu marca</span> en el mundo real y digital con <span
                        style="color: #56FF00;">eventos</span> que generan <span
                        style="color: #56FF00;">conversación</span>, <span style="color: #56FF00;">visibilidad</span> y
                    <span style="color: #56FF00;">resultados medibles</span>.
                </p>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
                <video src="{{ asset('img/que-ofrecemos/info-marketing-video.mp4') }}"
                    class="rounded shadow-lg anim-video-header" style="max-width: 320px; height: auto;" autoplay muted loop
                    playsinline></video>
            </div>
        </div>

        <div class="container" style="margin-top: 120px;">
            <div class="row">
                <div class="col-12">
                    <div class="rounded p-4 mb-4 d-flex flex-column flex-md-row align-items-center card-anim-hidden"
                        style="min-height: 160px;">
                        <img src="{{ asset('img/que-ofrecemos/info-marketing.webp')}}" alt="Destaca entre los demás"
                            class="img-fluid rounded shadow-lg anim-img-left mb-3 mb-md-0"
                            style="max-width: 160px; height: auto;">
                        <div class="ms-0 ms-md-4 w-100">
                            <h3 class="mb-2 fw-bold anim-card-content" style="color: #56FF00; font-size: 2rem;">
                                Identifica el <span style="color: #56FF00;">momento perfecto</span>
                            </h3>
                            <p class="mb-3 anim-card-content" style="color: #fff; font-size: 1.1rem; max-width: 350px;">
                                Conoce cuándo y dónde activar tu marca</p>
                            <ul class="ps-3 anim-card-content" style="color: #fff; font-size: 1.05rem; list-style: none;">
                                <li class="mb-2"><i class="bi bi-calendar-event fs-1" style="color:#56FF00;"></i> Detectamos
                                    <span style="color:#56FF00;">oportunidades clave</span> en tu industria y calendario
                                    cultural.
                                </li>
                                <li class="mb-2"><i class="bi bi-bar-chart-line fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">Análisis de audiencias</span> y comportamiento para maximizar
                                    <span style="color:#56FF00;">impacto</span>.
                                </li>
                                <li><i class="bi bi-compass fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">Planeación estratégica</span> adaptada a objetivos de <span
                                        style="color:#56FF00;">visibilidad</span> y <span
                                        style="color:#56FF00;">conversión</span>.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="rounded p-4 mb-4 d-flex flex-column flex-md-row-reverse align-items-center card-anim-hidden"
                        style="min-height: 160px;">
                        <img src="{{ asset('img/que-ofrecemos/info-marketing2.webp')}}" alt="Nota la mejora en tus ingresos"
                            class="img-fluid rounded shadow-lg anim-img-right mb-3 mb-md-0 ms-0 ms-md-4"
                            style="max-width: 160px; height: auto;">
                        <div class="w-100" style="max-width: 600px;">
                            <h3 class="mb-2 fw-bold anim-card-content-right"
                                style="color: #56FF00; font-size: 2rem; white-space: nowrap;">
                                Crea <span style="color: #56FF00;">experiencias memorables</span>
                            </h3>
                            <p class="mb-3 anim-card-content-right" style="color: #fff; font-size: 1.1rem;">Desde la idea
                                hasta la ejecución sin complicaciones</p>
                            <ul class="ps-3 anim-card-content-right"
                                style="color: #fff; font-size: 1.05rem; list-style: none;">
                                <li class="mb-2"><i class="bi bi-display fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">Producción</span> de eventos presenciales, híbridos y
                                    digitales.</li>
                                <li class="mb-2"><i class="bi bi-stars fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">Selección de talentos</span> alineados con los valores de tu
                                    marca.</li>
                                <li><i class="bi bi-tools fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">Coordinación integral</span>: logística, permisos y ejecución
                                    impecable.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="rounded p-4 mb-4 d-flex flex-column flex-md-row align-items-center card-anim-hidden"
                        style="min-height: 160px;">
                        <img src="{{ asset('img/que-ofrecemos/info-marketing3.webp')}}" alt="Mejora tus resultados"
                            class="img-fluid rounded shadow-lg anim-img-left mb-3 mb-md-0"
                            style="max-width: 160px; height: auto;">
                        <div class="ms-0 ms-md-4 w-100" style="max-width: 600px;">
                            <h3 class="mb-2 fw-bold anim-card-content"
                                style="color: #56FF00; font-size: 2rem; white-space: nowrap;">
                                Mide el <span style="color: #56FF00;">impacto real</span>
                            </h3>
                            <p class="mb-3 anim-card-content" style="color: #fff; font-size: 1.1rem;">No solo lo vivieron,
                                también lo compartieron</p>
                            <ul class="ps-3 anim-card-content" style="color: #fff; font-size: 1.05rem; list-style: none;">
                                <li class="mb-2"><i class="bi bi-wifi fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">Monitoreo en tiempo real</span> de participación e
                                    interacción.</li>
                                <li class="mb-2"><i class="bi bi-bar-chart fs-1" style="color:#56FF00;"></i> Reportes de
                                    <span style="color:#56FF00;">performance</span>: alcance, engagement y menciones.
                                </li>
                                <li><i class="bi bi-arrow-repeat fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">Aprendizajes</span> y mejoras para futuras activaciones.</li>
                            </ul>
                        </div>
                        <script src="{{ asset('js/animacion-servicios.js') }}"></script>
                    </div>
                </div>
                <div>
                </div>
            </div>
@endsection