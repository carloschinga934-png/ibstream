@extends('layouts.layout')
@section('content')
    {{-- priorizar el fondo negro --}}
    @section("title", "Consultoría | IBSTREAM")

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
                    Diagnóstico que impulsa tu <span style="color: #56FF00 ;">estrategia con influencers</span>
                </h2>
                <p class="fs-5 anim-header-delay" style="color: #fff; text-align: left; max-width: 400px;">
                    Aprovecha nuestro <span style="color: #56FF00 ;">análisis detallado</span> para escalar tu presencia con
                    <span style="color: #56FF00 ;">creadores de contenido</span> de forma efectiva y medible.
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
                            <h3 class="mb-2 fw-bold anim-card-content" style="color: #56FF00 ; font-size: 2rem;">
                                <span style="color: #56FF00 ;">Detecta</span> <span style="color: #fff;">oportunidades
                                    reales</span>
                            </h3>
                            <p class="mb-3 anim-card-content" style="color: #fff; font-size: 1.1rem; max-width: 350px;">
                                Analizamos tu ecosistema actual y detectamos áreas de mejora para que tomes decisiones
                                informadas.
                            </p>
                            <ul class="ps-3 anim-card-content" style="color: #fff; font-size: 1.05rem; list-style: none;">
                                <li class="mb-2"><i class="bi bi-kanban fs-1" style="color:#56FF00 ;"></i> <span
                                        style="color:#56FF00 ;">Auditoria</span> de canales y contenido</li>
                                <li class="mb-2"><i class="bi bi-graph-down fs-1" style="color:#56FF00 ;"></i> <span
                                        style="color: #56FF00 ;">Evaluación</span>de performance pasada
                                <li><i class="bi bi-people fs-1" style="color:#56FF00 ;"></i> Revisión de audiencias y
                                    perfiles <span style="color:#56FF00 ;">clave</span></li>
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
                                style="color: #fff; font-size: 2rem; white-space: nowrap;">
                                Compara, aprende y <span style="color: #56FF00 ;">mejora</span>
                            </h3>
                            <p class="mb-3 anim-card-content-right" style="color: #fff; font-size: 1.1rem;">Usamos
                                benchmarks del mercado para entender tu posición frente a la competencia.</p>
                            <ul class="ps-3 anim-card-content-right"
                                style="color: #fff; font-size: 1.05rem; list-style: none;">
                                <li class="mb-2"><i class="bi bi-globe fs-1" style="color:#56FF00 ;"></i> <span
                                        style="color:#56FF00 ;">Datos del sector</span> y competidores</li>
                                <li class="mb-2"><i class="bi bi-check-circle fs-1" style="color:#56FF00 ;"></i> <span
                                        style="color:#56FF00 ;">Buenas prácticas</span></li>
                                <li><i class="bi bi-clipboard-data fs-1" style="color:#56FF00 ;"></i> <span
                                        style="color:#56FF00 ;">Tendencias</span> de formato y engagement</li>
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
                                style="color: #56FF00 ; font-size: 2rem; white-space: nowrap;">
                                Mide lo que importa
                            </h3>
                            <p class="mb-3 anim-card-content" style="color: #fff; font-size: 1.1rem;">Establece KPIs claros
                                para dar seguimiento a tu evolución.</p>
                            <ul class="ps-3 anim-card-content" style="color: #fff; font-size: 1.05rem; list-style: none;">
                                <li class="mb-2"><i class="bi bi-bullseye fs-1" style="color:#56FF00 ;"></i> Definición de
                                    <span style="color:#56FF00 ;">indicadores clave</span>
                                </li>
                                <li class="mb-2"><i class="bi bi-stopwatch fs-1" style="color:#56FF00 ;"></i> Métodos de
                                    <span style="color:#56FF00 ;">seguimiento</span>
                                </li>
                                <li><i class="bi bi-tools fs-1" style="color:#56FF00 ;"></i> Herramientas sugeridas para
                                    <span style="color:#56FF00 ;">análisis</span>
                                </li>
                            </ul>
                        </div>
                        <script src="{{ asset('js/animacion-servicios.js') }}"></script>
                    </div>
                </div>
                <div>
                </div>
            </div>
@endsection