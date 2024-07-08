<div class="text-center m-5">
    <x-widgets.block-title title="О нас"></x-widgets.block-title>
    <div class="w-full h-full grid grid-cols-2 relative bg-cover bg-center bg-no-repeat">
        <div class="grid-cols-1">
            <div class="w-full m-5 text-left pr-5">
                <p class="text-description font-text-normal-plus font-weight-100">
                    Мы команда профессионалов работаем, чтобы у вас всегда был безупречный маникюр, нежные пяточки, гладкая упругая кожа, длинные пушистые ресницы и непоколебимая уверенность в себе.
                </p>
                <p class="text-description font-text-normal-plus font-weight-100 my-5 py-4">
                    Ваша красота — наша сила! Мы не просто оказываем услуги, мы создаем для вас новый образ жизни, в котором у вас всегда главная роль.
                </p>
                <x-button.route href="{{route('home')}}">
                    <x-button.default class="px-5 py-2.5 font-text-normal">
                        <p class="">Посмотреть фото</p>
                    </x-button.default>
                </x-button.route>
            </div>
        </div>
        <div class="grid-cols-1">
            <div class="w-auto bg-no-repeat m-5" style="aspect-ratio: 1/1; background-image: url({{ asset('images/salon/preview-about.png') }}"></div>
        </div>
    </div>
</div>

<style>
    .text-description{
        line-height: 4.5rem;
    }
</style>
