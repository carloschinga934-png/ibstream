// animacion general para cards de todas las secciones al hacer scroll
document.addEventListener("DOMContentLoaded", function() {
    // selecciona todos los elementos ocultos con la clase general
    const cards = document.querySelectorAll('.card-anim-hidden');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('card-anim-visible', 'anim-card-content');
                entry.target.classList.remove('card-anim-hidden');
            }
        });
    }, { threshold: 0.2 });

    cards.forEach(card => observer.observe(card));
});
