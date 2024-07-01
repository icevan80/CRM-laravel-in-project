<div style="height: 250px; width: 750px; margin: auto">
    <div id="carousel">
        <div class="carousel-prev-button" onclick="plusSlides(-1)"><p>lll</p></div>
        <div class="carousel-next-button" onclick="plusSlides(1)"><p>rrr</p></div>
        <div class="carousel-items-list">
            <div class="carousel-items-card primary-color"><p>aboba1</p></div>
            <div class="carousel-items-card primary-variant-color"><p>aboba2</p></div>
            <div class="carousel-items-card secondary-color"><p>aboba3</p></div>
            <div class="carousel-items-card secondary-variant-color"><p>aboba4</p></div>
            <div class="carousel-items-card error-color"><p>aboba5</p></div>
            <div class="carousel-items-card success-color"><p>aboba6</p></div>
        </div>
    </div>
</div>

<script>
    let showSlidesCount = 2;
    let slideIndex = showSlidesCount;
    let slides = document.getElementsByClassName("carousel-items-card");

    for (let k = 0; k < slides.length; k++) {
        slides[k].style.width = 100 / showSlidesCount + '%';
        slides[k].style.display = 'none';
    }

    for (let k = 0; k < showSlidesCount; k++) {
        slides[slideIndex + k].style.display = 'block';
    }

    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
        if (n > 0) {
            slides[slideIndex].style.display = "none";
        } else {
            slides[(slideIndex + n + showSlidesCount) % slides.length].style.display = "none";
        }
        showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {

        if (n < 0) {
            slideIndex = slides.length
        } else {
            slideIndex = n % slides.length;
        }
        let i;


        let startIndex = slideIndex;
        for(i = 0; i < showSlidesCount; i++) {
            slides[(startIndex + i) % slides.length].style.display = "block";
        }
    }

    function initCarousel() {
        let y = document.getElementsByClassName('carousel-items-list');
        // let sliderList = sliderList[0];
        // TODO: надо улучшить карусель
        // let sliderList.getElementsByClassName('carousel-items-card');

    }



    // document.getElementsByClassName("carousel-items-card").item(0).click(plusSlides(1))
</script>

<style>
    #carousel {
        position: relative;
        overflow: hidden;
    }

    .carousel-next-button {
        position: absolute;
        top: calc(50% - 1rem);
        z-index: 50;
        cursor: pointer;
        right: 0;
    }

    .carousel-prev-button {
        position: absolute;
        top: calc(50% - 1rem);
        z-index: 50;
        cursor: pointer;
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

    .carousel-dots {

    }

    .carousel-dots-item {

    }
</style>


