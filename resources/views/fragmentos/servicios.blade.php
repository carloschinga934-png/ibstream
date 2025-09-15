<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

@php
	// arreglo con los servicios que se muestran en las cards
	$servicios = [
		[

			'titulo' => 'Marketing Digital',
			'descripcion' => 'Estrategias full-funnel con creadores de contenido e integración de medios de pago.',
			'enlace' => url('/servicios/marketing'),
			'imagen' => asset('img/que-ofrecemos/marketing.webp'),
		],
		[
			'titulo' => 'Consultoría Estratégica',
			'descripcion' => 'Diagnóstico y roadmaps personalizados para escalar tu presencia con influencers y streamers.',
			'enlace' => url('/servicios/consultoria'),
			'imagen' => asset('img/que-ofrecemos/consultoria.webp'),
		],
		[
			'titulo' => 'Eventos y Activaciones',
			'descripcion' => 'Organización de eventos online y presenciales, seleccionando y negociando con perfiles alineados a tu marca.',
			'enlace' => url('/servicios/eventos-activaciones'),
			'imagen' => asset('img/que-ofrecemos/evento.webp'),
		],
		[
			'titulo' => '',
			'descripcion' => '',
			'enlace' => '#',
			'imagen' => asset(''),
		],
	];

@endphp
<div class="container">
	<h2 id="que-ofrecemos-titulo" class="apartado-titulo text-center mb-5 fw-bold" style="color:#56FF00 !important;">
		¿Qué ofrecemos?</h2>
	<div class="row justify-content-center gx-5 gy-5">
		@foreach($servicios as $i => $servicio)
			<div class="col-12 col-sm-10 col-md-6 col-lg-5 d-flex justify-content-center mb-4">

				@if($i == count($servicios)-1)
					<article class="card-que-ofrecemos card-bloqueada card-bloqueada-shine d-flex flex-column justify-content-center align-items-center" style="background:#000; min-height:220px;">
						<i class="bi bi-lock" style="font-size:3.5rem;color:#56FF00;text-shadow:0 0 16px #56FF00,0 0 32px #fff;"></i>
						<span style="color:#56FF00; font-weight:bold; font-size:1.2rem; margin-top:1rem; text-shadow:0 0 8px #56FF00;">Próximamente</span>
					</article>
				@else
					<article class="card-que-ofrecemos">
						<header class="w-100 text-center mb-3">
							<h3 class="card-title mb-2">{{ $servicio['titulo'] }}</h3>
						</header>
						@if(!empty($servicio['imagen']))
							<div class="mb-3 d-flex justify-content-center w-100 position-relative">
								<img src="{{ $servicio['imagen'] }}" alt="{{ $servicio['titulo'] }}" class="card-img" loading="lazy" />
							</div>
						@endif
						<div class="card-description text-center mb-3">
							{{ $servicio['descripcion'] }}
						</div>
						<div class="mt-auto">
							<a href="{{ $servicio['enlace'] }}" class="card-btn">Conoce más</a>
						</div>
					</article>
				@endif
			</div>
		@endforeach
	</div>
</div>
