<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'IBSTREAM')</title>

    <link rel="icon" type="image/png" href="{{ asset('img/1.webp') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/portada.css') }}">
    <link rel="stylesheet" href="{{ asset('css/influencers.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contactanos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/servicios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sobre-nosotros.css') }}">

    <!-- Splide (carrousel) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/js/splide.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @stack('styles')
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <img src="{{ asset('img/1.webp') }}" alt="Logo de IBSTREAM">
            </div>

            <!-- Botón hamburguesa -->
            <button class="menu-toggle" aria-expanded="false" aria-controls="primary-nav" aria-label="Abrir menú de navegación">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Navegación -->
            <nav id="primary-nav" class="navigation">
                <a href="{{ route('home') }}" class="nav-link">Inicio</a>
                <a href="{{ route('home') }}#about-us-section" class="nav-link">Sobre nosotros</a>
                <a href="{{ route('home') }}#servicios-section" class="nav-link">Servicios</a>
                <a href="{{ route('home') }}#influencers-section" class="nav-link">Influencers</a>
                <a href='{{ route('home') }}#contactanos-section' class="nav-link">Contáctanos</a>
                <a href='https://ibstream-peru.blogspot.com/' class="nav-link">Blog</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-ibcorp">
        <div class="footer-container">
            <!-- Logo -->
            <div class="footer-section">
                <img src="{{ asset('img/logo1.webp') }}" alt="Logo alternativo IBSTREAM">
                <h2 class="footer-brand">IBSTREAM</h2>
                <p class="footer-description">
                    Agencia de marketing especializada en trabajar con streamers e influencers, con base en Perú y aplicación regional.
                </p>
                <a href="#" class="footer-link">Conocer más →</a>
            </div>

            <!-- Enlaces -->
            <div class="footer-links">
                <h4>Sobre nosotros</h4>
                <ul>
                    <li><a href="#">¿Qué hacemos?</a></li>
                    <li><a href="#">¿Por qué lo hacemos?</a></li>
                    <li><a href="#">¿Quiénes somos?</a></li>
                </ul>
            </div>

            <!-- Servicios -->
            <div class="footer-services">
                <h4>Servicios</h4>
                <ul>
                    <li><a href="#">Marketing Digital</a></li>
                    <li><a href="#">Consultoria Estratégica</a></li>
                    <li><a href="#">Organización de eventos y Actividades</a></li>
                </ul>
            </div>

            <!-- Contacto -->
            <div class="footer-contact">
                <h4>Contáctanos</h4>
                <p><i class="fas fa-envelope"></i>gestion@corpibgroup.com</p>
                <p><i class="fa-brands fa-whatsapp"></i>+51 923 843 318</p>
                <p><i class="fas fa-map-marker-alt"></i>Av. Circunvalación Club Golf los Incas, Torre 3, Oficina 602B
                    Urb. Club Golf los Incas, Santiago de Surco, Lima – Perú</p>
            </div>
        </div>

        <!-- Redes Sociales -->
        <div class="footer-social">
            <h4>Síguenos</h4>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>

        <!-- Bottom -->
        <div class="footer-bottom">
            <div class="footer-bottom-container">
                <p class="footer-copyright">
                    Copyright © {{ date('Y') }} Todos los derechos reservados | IBCORP SAC.
                </p>
                <div class="footer-bottom-links">
                    <a href="#">Términos</a>
                    <a href="#">Política de privacidad</a>
                    <a href="#">Condiciones</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/influencers.js') }}"></script>

    <!-- Chatbot (solo en home) -->
    @if(request()->routeIs('home'))
        @include('chatbot.widget')
    @endif

    <!-- Script menú hamburguesa -->
    <script>
        (function () {
            const btn = document.querySelector('.menu-toggle');
            const nav = document.getElementById('primary-nav');
            if (!btn || !nav) return;

            btn.addEventListener('click', () => {
                const open = nav.classList.toggle('is-open');
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                document.body.style.overflow = open ? 'hidden' : '';
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth > 992 && nav.classList.contains('is-open')) {
                    nav.classList.remove('is-open');
                    btn.setAttribute('aria-expanded', 'false');
                    document.body.style.overflow = '';
                }
            });
        })();
    </script>

    <script>
        window.addEventListener("scroll", function() {
            const header = document.querySelector(".header");
            if (window.scrollY > 50) {
            header.classList.add("scrolled");
            } else {
            header.classList.remove("scrolled");
            }
        });
    </script>


</body>
</html>
