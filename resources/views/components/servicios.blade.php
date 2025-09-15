<!-- componente que muestra una card de servicio -->
<div class="card-que-ofrecemos animate-card">
	<h3 class="card-title">{{ $titulo }}</h3>
	@if(!empty($imagen))
		<div style="display:flex;justify-content:center;align-items:center;margin-bottom:1rem;">
			<img src="{{ $imagen }}" alt="{{ $titulo }}" class="card-img" style="width:130px;height:130px;object-fit:contain;" />
		</div>
	@endif
	<p class="card-description">{{ $descripcion }}</p>
	<a href="{{ $enlace }}" class="card-btn">Conoce más</a>
</div>
