document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.mySwiper').forEach(function (swiperContainer) {
        new Swiper(swiperContainer, {
            slidesPerView: 5,
            spaceBetween: 5,
            centeredSlides: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            slidesOffsetBefore: 30, /* Add 40px offset to the left of the first slide */
        });
    });
});