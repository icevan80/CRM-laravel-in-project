@props([
/** @var \mixed */
'categories'
])

<div>
    <x-widgets.block-title title="Выберите услугу"></x-widgets.block-title>
    @foreach($categories as $category)

        @if($loop->index % 3 == 0)
            <div class="flex mx-2.5">
                @endif
                <x-widgets.category-card height="318" :category="$category"></x-widgets.category-card>
                @if($loop->index % 3 == 2)
            </div>
        @endif

        @break($loop->iteration == 6)

    @endforeach
    <div>
        <div class="transform duration-150 hover:scale-105 inline-block">
            <a href="" class="font-text-normal-plus text-on-surface-color text-light-80 font-weight-200 underline">Все
                услуги</a>
        </div>
    </div>
</div>


