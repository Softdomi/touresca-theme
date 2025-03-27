

document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded and parsed");
    try {
        // Initialize Swiper
    const swiper = new Swiper('.swiper-container', {
        // Enable one slide at a time
        slidesPerView: 1,
        
        // Disable multiple slides being displayed at once
        direction: 'horizontal',
        
        // Set up pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        
        // Enable navigation buttons
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        
     
        
        // Disable multirow display
        grid: {
            rows: 1,
        },
        
        // Disable grouping slides
        slidesPerGroup: 1,
        
        // Update counter when slide changes
        on: {
            init: function() {
                updateCounter(this.realIndex + 1);
                console.log("Swiper initialized successfully");
            },
            slideChange: function() {
                updateCounter(this.realIndex + 1);
                console.log("Swiper initialized successfully");
            },
        },
    });
       
        console.log("Swiper initialized:", swiper);
    } catch (error) {
        console.error("Swiper failed to initialize:", error);
    }
 
    
    // Update the slide counter
    function updateCounter(current) {
        const currentSlideElement = document.querySelector('.current-slide');
        const totalSlidesElement = document.querySelector('.total-slides');
        
        if (currentSlideElement && totalSlidesElement) {
            currentSlideElement.textContent = current;
            // Subtract duplicate slides created by loop mode
            const totalSlides = document.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate)').length;
            totalSlidesElement.textContent = totalSlides;
        }
    }

      // Check if navigation buttons are being clicked
      document.querySelector(".swiper-button-next").addEventListener("click", function () {
        console.log("Next button clicked");
    });

    document.querySelector(".swiper-button-prev").addEventListener("click", function () {
        console.log("Prev button clicked");
    });
});
