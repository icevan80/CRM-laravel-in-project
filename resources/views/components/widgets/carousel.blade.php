@php
    $carouselId = $attributes['carouselId'];

    $carouselMargin = 'auto';
    if ($attributes['margin']) {
        $carouselMargin = $attributes['margin'];
    }

    $carouselWidth = 'auto';
    if ($attributes['width']) {
        $carouselWidth = $attributes['width'];
    }

    $carouselHeight = '100%';
    if ($attributes['height']) {
        $carouselHeight = $attributes['height'];
    }

    $carouselStartIndex = 0;
    if ($attributes['start']) {
        $carouselStartIndex = intval($attributes['start']);
    }

    $carouselSlideShow = 1;
    if ($attributes['showCount']) {
        $carouselSlideShow = intval($attributes['showCount']);
    }
@endphp

<div id="{{$carouselId}}"
     style="eight: {{ $carouselHeight }}; width: {{ $carouselWidth }}; ">
    <div class="carousel relative overflow-hidden w-full inline-flex" style="padding: {{ $carouselMargin }}">
        <div class="carousel-button prev hover:border-darken-35 transition ease-in-out duration-150 w-0 h-0"
             onclick="plusSlides('{{ $carouselId }}', -1)"></div>
        <div class="carousel-items-list grid relative w-full">
            {{ $slot }}
        </div>
        <div class="carousel-button next hover:border-darken-35 transition ease-in-out duration-150 w-0 h-0"
             onclick="plusSlides('{{ $carouselId }}', 1)"></div>
    </div>
    <div class="carousel-dots inline-flex mx-auto">
        @for($i = 0; $i < substr_count($slot, 'card-item-split-tag'); $i++)
            <div
                class="carousel-dots-item disable hover:bg-darken-35 transition ease-in-out duration-150 rounded-full cursor-pointer"
                onclick="currentSlide('{{ $carouselId }}', {{ $i }})"></div>
        @endfor
    </div>
</div>

<script>
    if (typeof showSlidesCount === 'undefined') {
        var showSlidesCount = new Map();
    }
    showSlidesCount.set('{{ $carouselId }}', {{ $carouselSlideShow }});
    if (typeof slideIndex === 'undefined') {
        var slideIndex = new Map();
    }
    slideIndex.set('{{ $carouselId }}', {{ $carouselStartIndex }});

    if (typeof mainDiv === 'undefined') {
        var mainDiv = new Map();
    }
    mainDiv.set('{{ $carouselId }}', document.getElementById('{{ $carouselId }}'));

    if (typeof interval === 'undefined') {
        var interval = new Map();
    }

    initCarousel('{{ $carouselId }}');

    function plusSlides(carouselId, n) {
        slideIndex.set(carouselId, slideIndex.get(carouselId) + n);
        showSlides(carouselId, slideIndex.get(carouselId));
        clearInterval(interval.get(carouselId));
        interval.set(carouselId, setInterval(function () {
            plusSlides(carouselId, 1);
        }, 5000));
    }

    function currentSlide(carouselId, n) {
        slideIndex.set(carouselId, n);
        showSlides(carouselId, slideIndex.get(carouselId));
        clearInterval(interval.get(carouselId));
        interval.set(carouselId, setInterval(function () {
            plusSlides(carouselId, 1);
        }, 5000));
    }

    function showSlides(carouselId, n) {
        let slides = mainDiv.get(carouselId).getElementsByClassName('carousel').item(0).getElementsByClassName("carousel-items-card");
        let dotes = mainDiv.get(carouselId).getElementsByClassName('carousel-dots').item(0).getElementsByClassName("carousel-dots-item");

        if (n < 0) {
            n = slides.length - 1;
            slideIndex.set(carouselId, n);
        }
        if (n === slides.length) {
            n = 0;
            slideIndex.set(carouselId, n);
        }

        if (n + showSlidesCount.get(carouselId) > slides.length - 1) {
            n = slides.length - showSlidesCount.get(carouselId);
        }

        for (let j = 0; j < slides.length; j++) {
            slides[j].style.display = "none";
        }
        for (let j = 0; j < showSlidesCount.get(carouselId); j++) {
            slides[n + j].style.display = "block";
        }


        for (let j = 0; j < dotes.length; j++) {
            dotes[j].classList.add('disable');
            dotes[j].classList.remove('active');

        }
        dotes[slideIndex.get(carouselId)].classList.add('active');
        dotes[slideIndex.get(carouselId)].classList.remove('disable');
    }

    function initCarousel(carouselId) {
        mainDiv.get(carouselId).getElementsByClassName("carousel-items-list").item(0).style.gridTemplateColumns = 'repeat(' + showSlidesCount.get(carouselId) + ', 1fr)';
        let slides = mainDiv.get(carouselId).getElementsByClassName('carousel').item(0).getElementsByClassName("carousel-items-list").item(0).children;
        for (let j = 0; j < slides.length; j++) {
            slides[j].classList.add('carousel-items-card')
        }
        let dotes = mainDiv.get(carouselId).getElementsByClassName('carousel-dots').item(0).getElementsByClassName("carousel-dots-item");
        if (slides.length < showSlidesCount.get(carouselId)) showSlidesCount.set('{{ $carouselId }}', slides.length);
        if (slides.length <= slideIndex.get(carouselId)) slideIndex.set('{{ $carouselId }}', 0);
        for (let j = 0; j < slides.length; j++) {
            slides[j].style.width = 'auto';
            slides[j].style.display = 'none';
        }
        for (let j = 0; j < showSlidesCount.get(carouselId); j++) {
            slides[slideIndex.get(carouselId) + j].style.display = 'block';
        }
        dotes[slideIndex.get(carouselId)].classList.add('active');
        dotes[slideIndex.get(carouselId)].classList.remove('disable');

        // interval.set(carouselId, setInterval(function () {
        //     plusSlides(carouselId, 1);
        // }, 5000));
    }
</script>
