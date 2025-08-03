document.addEventListener('DOMContentLoaded', function () {
    var carouselElement = document.getElementById('carouselExampleIndicators');
    var carouselCounter = document.getElementById('carouselCounter');
    var totalItems = carouselElement.querySelectorAll('.carousel-item').length;

    carouselElement.addEventListener('slid.bs.carousel', function (event) {
        var currentIndex = event.to + 1;
        carouselCounter.textContent = currentIndex + '/' + totalItems;
    });
});

function addToFavorites() {
    alert("Favorilere eklendi");
}

window.addEventListener('load', function() {
    const loadingElement = document.getElementById('loading');
    loadingElement.classList.add('hidden');
    setTimeout(function() {
        loadingElement.style.display = 'none';
    }, 500); // Geçiş süresi ile aynı olmalı
});







