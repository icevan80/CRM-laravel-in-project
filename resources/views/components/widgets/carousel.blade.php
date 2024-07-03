@php
    $carouselId = $attributes['carouselId'];

    $carouselWidth = 'auto';
    if ($attributes['carouselWidth']) {
        $carouselWidth = $attributes['carouselWidth'];
    }

    $carouselHeight = '100%';
    if ($attributes['carouselHeight']) {
        $carouselHeight = $attributes['carouselHeight'];
    }
@endphp

<div id="{{$carouselId}}" style="height: '{{ $carouselHeight }}'; width: '{{ $carouselWidth }}'; margin: auto">
    <div class="carousel">
        <div class="carousel-button prev hover:border-darken-35 transition ease-in-out duration-150"
             onclick="plusSlides('{{ $carouselId }}', -1)"></div>
        <div class="carousel-items-list">
            {{ $slot }}
        </div>
        <div class="carousel-button next hover:border-darken-35 transition ease-in-out duration-150"
             onclick="plusSlides('{{ $carouselId }}', 1)"></div>
    </div>
    <div class="carousel-dots">
        @for($i = 0; $i < count(explode('
', $slot)); $i++)
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
    showSlidesCount.set('{{ $carouselId }}', 2);
    if (typeof slideIndex === 'undefined') {
        var slideIndex = new Map();
    }
    slideIndex.set('{{ $carouselId }}', 0);

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
        clearInterval(interval);
        interval = setInterval(function () {
            plusSlides(carouselId, 1);
        }, 5000);
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
        let slides = mainDiv.get(carouselId).getElementsByClassName('carousel').item(0).getElementsByClassName("carousel-items-list").item(0).children;
        for (let j = 0; j < slides.length; j++) {
            slides[j].classList.add('carousel-items-card')
        }
        let dotes = mainDiv.get(carouselId).getElementsByClassName('carousel-dots').item(0).getElementsByClassName("carousel-dots-item");
        if (slides.length < showSlidesCount.get(carouselId)) showSlidesCount.set('{{ $carouselId }}', slides.length);
        for (let j = 0; j < slides.length; j++) {
            slides[j].style.width = 100 / showSlidesCount.get(carouselId) + '%';
            slides[j].style.display = 'none';
        }
        for (let j = 0; j < showSlidesCount.get(carouselId); j++) {
            slides[slideIndex.get(carouselId) + j].style.display = 'block';
        }
        dotes[slideIndex.get(carouselId)].classList.add('active');
        dotes[slideIndex.get(carouselId)].classList.remove('disable');

        interval.set(carouselId, setInterval(function () {
            plusSlides(carouselId, 1);
        }, 5000));
    }
</script>

<style>
    .carousel {
        position: relative;
        overflow: hidden;
        width: 100%;
        display: inline-flex;
    }

    .carousel-button {
        margin: auto 1rem;
        width: 0;
        height: 0;
        border-top: 3.5rem solid transparent;
        border-bottom: 3.5rem solid transparent;
        z-index: 5;
        cursor: pointer;
    }

    .carousel-button.next {
        --tw-border-opacity: 1;
        --border-color-s: var(--primary-s);
        --border-color-l: var(--primary-l);
        border-left: 3.5rem solid hsl(var(--primary-h) var(--border-color-s-h, var(--border-color-s-f, var(--border-color-s-c, var(--border-color-s)))) var(--border-color-l-h, var(--border-color-l-f, var(--border-color-l-c, var(--border-color-l)))) / var(--tw-border-opacity));
    }

    .carousel-button.prev {
        --tw-border-opacity: 1;
        --border-color-s: var(--primary-s);
        --border-color-l: var(--primary-l);
        border-right: 3.5rem solid hsl(var(--primary-h) var(--border-color-s-h, var(--border-color-s-f, var(--border-color-s-c, var(--border-color-s)))) var(--border-color-l-h, var(--border-color-l-f, var(--border-color-l-c, var(--border-color-l)))) / var(--tw-border-opacity));
    }

    .carousel-items-list {
        position: relative;
        width: 100%;
    }

    .carousel-items-card {
        position: relative;
        display: block;
        float: left;
        text-align: center;
        line-height: 200px;
    }

    .carousel-dots {
        display: inline-flex;
    }

    .carousel-dots-item {
        width: 1rem;
        height: 1rem;
        margin: 0.5rem;
    }

    .carousel-dots-item.disable {
        --tw-bg-opacity: 1;
        --bg-color-s: var(--surface-s);
        --bg-color-l: var(--surface-l);
        --bg-color-s-h: initial;
        --bg-color-s-f: initial;
        --bg-color-s-c: initial;
        --bg-color-l-f: initial;
        --bg-color-l-c: 80;
        background-color: hsl(var(--surface-h) var(--bg-color-s-h, var(--bg-color-s-f, var(--bg-color-s-c, var(--bg-color-s)))) var(--bg-color-l-h, var(--bg-color-l-f, var(--bg-color-l-c, var(--bg-color-l)))) / var(--tw-bg-opacity));
    }

    .carousel-dots-item.active {
        --tw-bg-opacity: 1;
        --bg-color-s: var(--primary-s);
        --bg-color-l: var(--primary-l);
        --bg-color-s-h: initial;
        --bg-color-s-f: initial;
        --bg-color-s-c: initial;
        --bg-color-l-f: initial;
        --bg-color-l-c: initial;
        background-color: hsl(var(--primary-h) var(--bg-color-s-h, var(--bg-color-s-f, var(--bg-color-s-c, var(--bg-color-s)))) var(--bg-color-l-h, var(--bg-color-l-f, var(--bg-color-l-c, var(--bg-color-l)))) / var(--tw-bg-opacity));
    }
</style>


