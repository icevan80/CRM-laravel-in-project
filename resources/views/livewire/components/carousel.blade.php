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
    <div>

    </div>
</div>

<script>
    let showSlidesCount = 2;
    let slideIndex = 0;
    // let slides = document.getElementsByClassName("carousel-items-card");

    initCarousel();
    // showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let slides = document.getElementsByClassName("carousel-items-card");

        if (n < 0) {
            slideIndex = 0;
            return;
        }
        if (n >= slides.length) {
            slideIndex = slides.length - 1;
            return;
        }
        let i;

        if (n + showSlidesCount > slides.length - 1) {
            n = slides.length - showSlidesCount;
        }
        if (n - 1 >= 0) {
            slides[n - 1].style.display = "none";
        }
        for (i = 0; i < showSlidesCount; i++) {
            slides[n + i].style.display = "block";
        }
        if (n + showSlidesCount < slides.length) {
            slides[n + showSlidesCount].style.display = "none";
        }


        // let startIndex = slideIndex;
        // for(i = 0; i < showSlidesCount; i++) {
        //     slides[(startIndex + i) % slides.length].style.display = "block";
        // }
    }

    function initCarousel() {
        // let y = document.getElementsByClassName('carousel-items-list');
        let slides = document.getElementsByClassName("carousel-items-card");
        let i = slideIndex;
        if (slides.length < showSlidesCount) showSlidesCount = slides.length;
        for (let j = 0; j < slides.length; j++) {
            slides[j].style.width = 100 / showSlidesCount + '%';
            slides[j].style.display = 'none';
        }
        for (let j = 0; j < showSlidesCount; j++) {
            slides[i + j].style.display = 'block';
        }
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


