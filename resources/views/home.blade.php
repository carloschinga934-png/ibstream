@extends('layouts.layout')
@section('content')
    <section class="portada" id="portada-section">
        @include('fragmentos.portada')
    </section>
    <section class="about-us-section py-5" id="about-us-section">
        @include('fragmentos.sobre-nosotros')
    </section>

    <!-- seccion principal que muestra los servicios en cards -->
    <section class="que-ofrecemos py-5" id="servicios-section" aria-labelledby="que-ofrecemos-titulo">
        @include('fragmentos.servicios')
    </section>
    <section id="influencers-section">
        @include('fragmentos.influencers')
    </section>
    <section id="contactanos-section">
        <!-- SECCIÓN CONTACTANOS -->
        @include('fragmentos.contactanos')
    </section>
@endsection