jQuery( document ).ready(function($) {

    // Initialize AOS (Animate On Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 500,
            offset: 0,
            once: true,
            easing: 'ease-out-cubic',
        });

        // Refresh after images/fonts load to recalculate positions
        $(window).on('load', function() {
            AOS.refresh();
        });
    }

    // Initialize BeefUp Accordion (FAQ blocks)
    if ($.fn.beefup) {
        $('.faq-item').beefup({
            trigger: '.faq-question',
            content: '.faq-answer',
            openSingle: true,
            animation: 'slide',
            duration: 300
        });
    }

    // Initialize Slick Carousel (Testimonials)
    if ($.fn.slick) {
        $('.testimonials-carousel').slick({
            dots: true,
            arrows: true,
            infinite: true,
            speed: 500,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            prevArrow: '<button type="button" class="slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fa-solid fa-chevron-right"></i></button>',
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        arrows: false
                    }
                }
            ]
        });
    }

    // Initialize Slick Carousel (Hero Slider)
    if ($.fn.slick) {
        $('.heroslider-carousel').each(function() {
            var $carousel = $(this);
            var config = $carousel.data('slider-config') || {};

            $carousel.slick({
                dots: config.dots !== false,
                arrows: config.arrows !== false,
                infinite: true,
                speed: 800,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: config.autoplay !== false,
                autoplaySpeed: config.autoplaySpeed || 5000,
                fade: config.fade !== false,
                cssEase: 'ease-in-out',
                pauseOnHover: false,
                prevArrow: '<button type="button" class="slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fa-solid fa-chevron-right"></i></button>'
            });
        });
    }

    // Initialize Magnific Popup (Gallery lightbox)
    if ($.fn.magnificPopup) {
        $('.gallery-grid').magnificPopup({
            delegate: 'a.gallery-lightbox',
            type: 'image',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1]
            },
            image: {
                titleSrc: function(item) {
                    return item.el.attr('data-caption') || '';
                }
            }
        });
    }

    // Gallery category filter
    $('.gallery-filters').on('click', '.gallery-filter-btn', function() {
        var $btn = $(this);
        var category = $btn.data('filter');
        var $grid = $btn.closest('.gallery-block').find('.gallery-grid');

        $btn.siblings().removeClass('active');
        $btn.addClass('active');

        if (category === 'all') {
            $grid.find('.gallery-item').fadeIn(300);
        } else {
            $grid.find('.gallery-item').hide();
            $grid.find('.gallery-item[data-category="' + category + '"]').fadeIn(300);
        }
    });

    // Stats counter animation
    function animateCounters() {
        $('.stats-number[data-count]').each(function() {
            var $this = $(this);
            if ($this.data('animated')) return;

            var offset = $this.offset().top;
            var scrollTop = $(window).scrollTop();
            var windowHeight = $(window).height();

            if (scrollTop + windowHeight > offset + 50) {
                $this.data('animated', true);
                var target = parseInt($this.data('count'), 10);
                var prefix = $this.data('prefix') || '';
                var suffix = $this.data('suffix') || '';
                var duration = 2000;
                var startTime = null;

                function step(timestamp) {
                    if (!startTime) startTime = timestamp;
                    var progress = Math.min((timestamp - startTime) / duration, 1);
                    var eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
                    var current = Math.floor(eased * target);
                    $this.text(prefix + current.toLocaleString() + suffix);
                    if (progress < 1) {
                        requestAnimationFrame(step);
                    } else {
                        $this.text(prefix + target.toLocaleString() + suffix);
                    }
                }
                requestAnimationFrame(step);
            }
        });
    }

    $(window).on('scroll', animateCounters);
    animateCounters(); // Run on load too

    // Video play button overlay
    $('.video-play-btn').on('click', function(e) {
        e.preventDefault();
        var $block = $(this).closest('.video-block');
        var $thumbnail = $block.find('.video-thumbnail-wrapper');
        var $embed = $block.find('.video-embed');
        var videoUrl = $embed.data('video-url');

        if (videoUrl) {
            // Convert YouTube/Vimeo URLs to embed URLs
            var embedUrl = videoUrl;
            var youtubeMatch = videoUrl.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/);
            var vimeoMatch = videoUrl.match(/vimeo\.com\/(\d+)/);

            if (youtubeMatch) {
                embedUrl = 'https://www.youtube.com/embed/' + youtubeMatch[1] + '?autoplay=1&rel=0';
            } else if (vimeoMatch) {
                embedUrl = 'https://player.vimeo.com/video/' + vimeoMatch[1] + '?autoplay=1';
            }

            $embed.html('<iframe src="' + embedUrl + '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>');
            $thumbnail.fadeOut(300, function() {
                $embed.fadeIn(300);
            });
        }
    });

});
