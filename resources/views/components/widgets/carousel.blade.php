<div style="height: 250px; width: 750px; margin: auto">
    <div id="carousel">
        <div class="carousel-button prev" onclick="plusSlides(-1)"><p>lll</p></div>
        <div class="carousel-button next" onclick="plusSlides(1)"><p>rrr</p></div>
        <div class="carousel-items-list">
            {{ $slot }}
        </div>
    </div>
    <div id="carousel-dots">
        @for($i = 0; $i < count(explode('
', $slot)); $i++)
            <div class="carousel-dots-item disable" onclick="currentSlide({{ $i }})">ABOBA</div>
        @endfor
    </div>
</div>

<script>
    let showSlidesCount = 2;
    let slideIndex = 0;
    let carousel = document.getElementById('carousel')
    let carouselDotes = document.getElementById('carousel-dots')

    initCarousel();

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let slides = carousel.getElementsByClassName("carousel-items-card");
        let dotes = carouselDotes.getElementsByClassName("carousel-dots-item");

        if (n < 0) {
            slideIndex = 0;
            return;
        }
        if (n >= slides.length) {
            slideIndex = slides.length - 1;
            return;
        }

        if (n + showSlidesCount > slides.length - 1) {
            n = slides.length - showSlidesCount;
        }

        for(let j = 0; j < slides.length; j++) {
            slides[j].style.display = "none";
        }
        for (let j = 0; j < showSlidesCount; j++) {
            slides[n + j].style.display = "block";
        }

        for(let j = 0; j < dotes.length; j++) {
            dotes[j].classList.add('disable');
            dotes[j].classList.remove('active');

        }
        dotes[slideIndex].classList.add('active');
        dotes[slideIndex].classList.remove('disable');
    }

    function initCarousel() {

        // let y = document.getElementsByClassName("carousel-items-list");
        // let slidesList = y[0];
        // let slides = slidesList.children;
        // for(let j = 0; j < slides.length; j++) {
        //     slides[j].addClass('carousel-items-card')
        // }
        // slides = document.getElementsByClassName("carousel-items-card");
        let slides = carousel.getElementsByClassName("carousel-items-card");
        let dotes = carouselDotes.getElementsByClassName("carousel-dots-item");
        if (slides.length < showSlidesCount) showSlidesCount = slides.length;
        for (let j = 0; j < slides.length; j++) {
            slides[j].style.width = 100 / showSlidesCount + '%';
            slides[j].style.display = 'none';
        }
        for (let j = 0; j < showSlidesCount; j++) {
            slides[slideIndex + j].style.display = 'block';
        }
        dotes[slideIndex].classList.add('active');
        dotes[slideIndex].classList.remove('disable');
    }


    // document.getElementsByClassName("carousel-items-card").item(0).click(plusSlides(1))
</script>

<style>
    #carousel {
        position: relative;
        overflow: hidden;
    }

    .carousel-button {
        position: absolute;
        top: calc(50% - 1rem);
        z-index: 5;
        cursor: pointer;
    }

    .carousel-button.next {
        right: 0;

    }

    .carousel-button.prev {
        left: 0;

    }

    .carousel-items-list {
        position: relative;
    }

    .carousel-items-card {
        position: relative;
        display: block;
        float: left;
        text-align: center;
        line-height: 200px;
    }

    #carousel-dots {
        display: inline-flex;
    }

    .carousel-dots-item {

    }

    .carousel-dots-item.disable {
        background-color: red;
    }

    .carousel-dots-item.active {
        background-color: green;
    }


</style>


