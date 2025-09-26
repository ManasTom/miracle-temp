$(document).ready(function () {
    // Initialize AOS (Animate On Scroll)
    AOS.init({
        duration: 800,
        once: true
    });
});




document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector(".hero-slider-container");
    const slides = document.querySelectorAll(".hero-slide-item");
    const prevBtn = document.querySelector(".hero-slider-btn.prev");
    const nextBtn = document.querySelector(".hero-slider-btn.next");
    let current = 0;
    let slideInterval;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove("active");
            slide.style.position = "absolute"; 
        });
        slides[index].classList.add("active");
        slides[index].style.position = "relative"; 

        container.style.height = slides[index].scrollHeight + "px";
    }

    function nextSlide() {
        current = (current + 1) % slides.length;
        showSlide(current);
    }

    function prevSlide() {
        current = (current - 1 + slides.length) % slides.length;
        showSlide(current);
    }

    // Init
    showSlide(current);

    // Auto slide
    function startAutoSlide() {
        slideInterval = setInterval(nextSlide, 6000);
    }

    function stopAutoSlide() {
        clearInterval(slideInterval);
    }

    startAutoSlide();

    // Controls
    nextBtn.addEventListener("click", () => {
        stopAutoSlide();
        nextSlide();
        startAutoSlide();
    });

    prevBtn.addEventListener("click", () => {
        stopAutoSlide();
        prevSlide();
        startAutoSlide();
    });
});



const accHeaders = document.querySelectorAll(".accordion-header");
accHeaders.forEach(header => {
    header.addEventListener("click", () => {
        header.classList.toggle("active");

        const content = header.nextElementSibling;
        if (header.classList.contains("active")) {
            content.style.maxHeight = content.scrollHeight + "px";
        } else {
            content.style.maxHeight = null;
        }
    });
});