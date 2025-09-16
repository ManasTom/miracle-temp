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
    let current = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove("active");
            slide.style.position = "absolute"; // keep others stacked
        });
        slides[index].classList.add("active");
        slides[index].style.position = "relative"; // let active one decide height

        // adjust container height to match active slide
        container.style.height = slides[index].scrollHeight + "px";
    }

    // Init
    showSlide(current);

    setInterval(() => {
        current = (current + 1) % slides.length;
        showSlide(current);
    }, 6000);
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