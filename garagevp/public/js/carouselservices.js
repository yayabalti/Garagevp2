document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner toutes les slides
    const slides = document.querySelectorAll('.carousel-slide');
    let currentSlide = 0;
    
    // Fonction pour afficher une slide
    function showSlide(index) {
        // Cacher toutes les slides
        slides.forEach(slide => {
            slide.classList.remove('active');
        });
        
        // Afficher la slide actuelle
        slides[index].classList.add('active');
    }
    
    // Afficher la première slide
    showSlide(0);
    
    // Fonction pour passer à la slide suivante
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }
    
    // Changer de slide toutes les 5 secondes
    setInterval(nextSlide, 4000);
});