gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

ScrollSmoother.create({

    smooth: 1,

    effects: true,

});

$(document).ready(function() {
    // An empty box reads back as NaN, and NaN survives both arithmetic and
    // comparison: NaN + 1 is NaN, and "NaN < 1" is false, so neither button
    // did anything until someone typed a number first. Treat blank as zero.
    function stepperCount($input) {
        var n = parseInt($input.val(), 10);
        return isNaN(n) ? 0 : n;
    }

    function stepperBound($input, name, fallback) {
        var n = parseInt($input.data(name), 10);
        return isNaN(n) ? fallback : n;
    }

    $('.minus').click(function () {
        var $input = $(this).parent().find('input');
        var max = stepperBound($input, 'max', Infinity);
        // A sold-out room has a ceiling of zero, and the usual floor of one
        // must not push the box back above it.
        var min = Math.min(stepperBound($input, 'min', 1), max);

        $input.val(Math.max(min, stepperCount($input) - 1)).change();
        return false;
    });

    $('.plus').click(function () {
        var $input = $(this).parent().find('input');
        var max = stepperBound($input, 'max', Infinity);

        $input.val(Math.min(max, stepperCount($input) + 1)).change();
        return false;
    });
});



var swiper = new Swiper(".fifth_slider", {
    slidesPerView: 1,
    spaceBetween: 20,
    speed: 1000,
    navigation: {
      nextEl: ".fifth_slide_next",
      prevEl: ".fifth_slide_prev",
    },
    breakpoints: {
        640: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 4,
        },
        1024: {
          slidesPerView: 4,
        },
      },
  });
  

// var swiper = new Swiper(".member_slider", {
//   slidesPerView: 1,
//   spaceBetween: 10,
//   speed: 1000,
//   pagination: {
//     el: ".swiper-pagination",
//     dynamicBullets: true,
//     clickable: true,
//   },
//   breakpoints: {
//     640: {
//       slidesPerView: 2,
//     },
//     768: {
//       slidesPerView: 2,
//     },
//     1024: {
//       slidesPerView: 3,
//     },
//   },
// });