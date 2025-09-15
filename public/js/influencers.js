document.addEventListener('DOMContentLoaded', function () {
  var splide = new Splide('.splide', {
    type: 'loop',        // loop infinito
    perPage: 4,          // cuántos slides se muestran en desktop
    perMove: 1,          // cuántos avanza por vez
    gap: '1rem',         // espacio entre slides
    autoplay: true,      // que avance solo
    pauseOnHover: true,  // se pausa si pasas el mouse
    pagination: false,   // sin paginación
    arrows: true,        // flechas visibles
    keyboard: 'global',  // accesibilidad con teclado
    breakpoints: {
      1280: { perPage: 3, gap: '0.75rem' },
      992:  { perPage: 2, gap: '0.75rem' },
      576:  { perPage: 1, gap: '0.5rem'  }
    }
  });

  splide.mount();
});
