/**
 * Dependencies
 */
import Swiper from '../vendor/swiper/swiper.js';

var SwiperUi = (function() {
     
	var _initialize = function() {
        var swiper = new Swiper('.swiper-container', {
            autoHeight: false,
            // autoplay: {
            //     delay: 3000,
            // },
            pagination: {
              el: '.swiper-pagination',
              clickable: true,
            },
            navigation: {
                nextEl: '.swiper-nav-next',
                prevEl: '.swiper-nav-prev'
            }
        });

        // Highlight slideshow
        var highlightEl = document.querySelector('.highlight-swiper');
        if (highlightEl) {
            var highlightSwiper = new Swiper('.highlight-swiper', {
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: 4500,
                    disableOnInteraction: false
                },
                loop: true,
                speed: 800,
                autoHeight: false
            });

            // Pause autoplay on video slides
            highlightSwiper.on('slideChangeTransitionEnd', function() {
                var activeSlide = highlightSwiper.slides[highlightSwiper.activeIndex];
                var video = activeSlide ? activeSlide.querySelector('video') : null;
                if (video) {
                    highlightSwiper.autoplay.stop();
                    video.currentTime = 0;
                    video.play();
                    // Resume after one loop of the video
                    video.addEventListener('ended', function onEnded() {
                        video.removeEventListener('ended', onEnded);
                        highlightSwiper.autoplay.start();
                    });
                }
            });
        }
    };

    return {
        init:  _initialize,
	};
	
})();

// Initialize
$(function() {
    SwiperUi.init();
});