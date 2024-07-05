@props([
/** @var \mixed */
'categories'
])

<div class="text-center my-5">
    <x-widgets.block-title title="Выберите услугу"></x-widgets.block-title>
    @foreach($categories as $category)

        @if($loop->index % 3 == 0)
            <div class="flex mx-2.5">
                @endif
                <x-cards.category height="318" :category="$category"></x-cards.category>
                @if($loop->index % 3 == 2)
            </div>
        @endif

        @break($loop->iteration == 6)

    @endforeach
    <div>
        <div class="transform duration-150 hover:scale-105 inline-block">
            <a href="" class="font-text-normal-plus text-on-surface-color text-light-80 underline font-weight-200 ">
                <p class="">Все услуги</p>
            </a>
        </div>
    </div>
</div>


