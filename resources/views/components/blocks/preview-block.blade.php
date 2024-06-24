<div class="w-full h-full grid grid-cols-2 relative bg-cover bg-center bg-no-repeat"
     style="background-image: url({{ asset('images/salon/preview-desktop.png') }}">
    <div class="grid-cols-1">
        <div class="preview-text-div h-full">
            <p class="font-title-big text-slogan">
                Ваша красота - наша сила!
            </p>
            <p class="font-title-small secondary-font text-special text-primary-color">
                Дарим скидку 10% на первое посещение
            </p>

            <x-button.route href="{{route('services')}}">
                <x-button.secondary class="px-5 py-2.5 font-text-normal">
                    <p class="">Записаться онлайн</p>
                </x-button.secondary>
            </x-button.route>
        </div>
    </div>
    <div class="grid-cols-1">
        <div class="preview-photo-div"></div>
    </div>
</div>


<style>
    .preview-text-div {
        margin: 10% 0 20% 10%;
    }

    .preview-photo-div {
        height: 100vh;
    }

    .text-slogan {
        font-weight: 200;
        line-height: 11rem;
    }

    .text-special {
        margin: 14rem 0 9rem 0;
        line-height: 6.5rem;
    }
</style>
