gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

ScrollSmoother.create({

    smooth: 1,

    effects: true,

});

$(document).ready(function() {
    $('.minus').click(function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.plus').click(function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
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