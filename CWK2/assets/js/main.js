// main swiper home
var swiper = new Swiper(".bannerSwiper", {
    spaceBetween: 30,
    effect: "fade",
    autoplay: true,
    // navigation: {
    //     nextEl: ".swiper-button-next",
    //     prevEl: ".swiper-button-prev",
    // },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

// home section 2 swiper
var swiper = new Swiper(".homeSection2", {
    slidesPerView: 3,
    spaceBetween: 30,
    // pagination: {
    //   el: ".swiper-pagination",
    //   clickable: true,
    // },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
  });

