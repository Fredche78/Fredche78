document.addEventListener('DOMContentLoaded', function () {

    new Splide('#splideReviews', {
        type: "loop",
        pagination: false,
        rewind: true,
        rewindByDrag: true,
        interval: number = 6000,
        speed: number = 1500,
        pauseOnHover: true,
        perPage: 1,
        autoplay: true,
        keyboard: true,
        // wheel: true,
        // releaseWheel: true,
        // direction: "ttb" = "ltr",
    }).mount();

    new Splide('#splidePictures', {
        type: "loop",
        rewind: true,
        rewindByDrag: true,
        interval: number = 10000,
        speed: number = 3000,
        pauseOnHover: true,
        perPage: 1,
        autoplay: true,
        keyboard: true,
    }).mount();
    
});

// new Splide('.splide', {
//     classes: {
//         arrows: 'splide__arrows your-class-arrows',
//         arrow: 'splide__arrow your-class-arrow',
//         prev: 'splide__arrow--prev slide__arrow--prev',
//         next: 'splide__arrow--next slide__arrow--next',
//     },
// });

