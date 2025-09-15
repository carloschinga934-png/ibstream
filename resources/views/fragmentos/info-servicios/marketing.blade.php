@extends('layouts.layout')
@section('content')
{{-- priorizar el fondo negro --}}
@section("title", "Marketing | IBSTREAM")

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
                <h2 class="fw-bold display-4 mb-3 anim-header" style="color: #56FF00; text-align: left; line-height: 1.1;">
                    Impulsa tus ventas con<br>
                    <span style="color: #fff;">estrategias de marketing</span><br>
                    <span style="color: #fff;">que sí convierten</span>
                </h2>
                <p class="fs-5 anim-header-delay" style="color: #fff; text-align: left; max-width: 400px;">
                    Aprovecha nuestro enfoque <span style="color: #56FF00; font-weight: bold;">full-funnel</span> para
                    atraer, conectar y convertir a tus clientes con campañas efectivas.
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
                                <span style="color: #56FF00;">Destaca</span> <span style="color: #fff;">sobre todos los
                                    demás</span>
                            </h3>
                            <p class="mb-3 anim-card-content" style="color: #fff; font-size: 1.1rem; max-width: 350px;">
                                Valoramos tu autenticidad, tu potencial de crecimiento y el match que haces con tu público.
                            </p>
                            <ul class="ps-3 anim-card-content" style="color: #fff; font-size: 1.05rem; list-style: none;">
                                <li class="mb-2"><i class="bi bi-people fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">Trabajamos</span> con los mejores talentos</li>
                                <li class="mb-2"><i class="bi bi-bar-chart fs-1" style="color:#56FF00;"></i> Analizamos tu
                                    valor más allá de los <span style="color:#56FF00;">números</span></li>
                                <li><i class="bi bi-link-45deg fs-1" style="color:#56FF00;"></i> Conectamos marcas con <span
                                        style="color:#56FF00;">personas</span>, no solo perfiles</li>
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
                                Convierte <span style="color: #56FF00">tus ideas</span> <span style="color: #fff;">en
                                    ingresos</span>
                            </h3>
                            <p class="mb-3 anim-card-content-right" style="color: #fff; font-size: 1.1rem;">Resultados
                                reales, ingresos medibles.</p>
                            <ul class="ps-3 anim-card-content-right"
                                style="color: #fff; font-size: 1.05rem; list-style: none;">
                                <li class="mb-2"><i class="bi bi-graph-up fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">Seguimiento</span> de rendimiento en tiempo real</li>
                                <li class="mb-2"><i class="bi bi-graph-up-arrow fs-1" style="color:#56FF00;"></i>
                                    Proyecciones y <span style="color:#56FF00;">control</span> de ingresos</li>
                                <li><i class="bi bi-arrow-repeat fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">Optimización</span> constante para mayor rentabilidad</li>
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
                                Estrategias que se adaptan a <span style="color: #56FF00;">ti</span>
                            </h3>
                            <p class="mb-3 anim-card-content" style="color: #fff; font-size: 1.1rem;">Desde tus primeros
                                pasos hasta campañas a gran escala.</p>
                            <ul class="ps-3 anim-card-content" style="color: #fff; font-size: 1.05rem; list-style: none;">
                                <li class="mb-2"><i class="bi bi-compass fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">Acompañamiento</span> estratégico</li>
                                <li class="mb-2"><i class="bi bi-sliders fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">Planes</span> personalizados</li>
                                <li><i class="bi bi-graph-up-arrow fs-1" style="color:#56FF00;"></i> <span
                                        style="color:#56FF00;">¡Crecemos</span> contigo!</li>
                            </ul>
                        </div>
                        <script src="{{ asset('js/animacion-servicios.js') }}"></script>
                    </div>
                </div>
                <div>
                </div>
            </div>
@endsection