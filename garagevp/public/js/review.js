let currentSlide = 0;
const slides = document.querySelectorAll('.review-slide');
const totalSlides = slides.length;

function moveSlide(direction) {
    currentSlide += direction;

    if (currentSlide < 0) {
        currentSlide = totalSlides - 5;
    } else if (currentSlide >= totalSlides) {
        currentSlide = 0;
    }

    const carouselContainer = document.querySelector('.carousel-container');
    carouselContainer.style.transform = `translateX(-${currentSlide * (100 / 4)}%)`;
}


// Gestion de la modal (popup)
function openReviewModal() {
    document.getElementById('reviewModal').style.display = 'block';
}

function closeReviewModal() {
    document.getElementById('reviewModal').style.display = 'none';
}

// Fermer la modal si on clique en dehors
window.onclick = function(event) {
    let modal = document.getElementById('reviewModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}



