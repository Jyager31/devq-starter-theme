jQuery( document ).ready(function($) {

    // Initialize AOS (Animate On Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,     // Animation duration
            offset: 100,       // Trigger animation 100px before element is in view
            once: true,        // Animate only once (better performance)
            easing: 'ease-out', // Smooth easing
            disable: function() {
                // Disable animations on mobile if preferred
                var maxWidth = 768;
                return window.innerWidth < maxWidth ? false : false;
            }
        });
    }

    // Initialize BeefUp Accordion (FAQ blocks)
    if ($.fn.beefup) {
        $('.faq-accordion').beefup({
            trigger: '.faq-question',
            content: '.faq-answer',
            openSingle: true,
            animation: 'slide',
            duration: 300
        });
    }

});
