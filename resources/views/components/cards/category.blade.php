@props([
/** @var \mixed */
'category'
])

@php
    $cardHeight = $attributes['height'].'px';
@endphp

<a href=""
   {{ $attributes->class([
   'm-2.5 w-full primary-gradient-border pb-20 transform overflow-hidden
   background-color shadow-md duration-300 hover:scale-105 hover:shadow-lg'
   ]) }}
   style="height:{{ $cardHeight }};">
    <div class="grid grid-cols-5 h-inherit">
        <div class="grid-group-1/4 overflow-hidden">
            <div>
                <img  src="{{ asset('storage/' . $category->image) }}" alt="" class="object-center">
            </div>
        </div>
        <div class="background-color border-margin grid-group-4/6 overflow-hidden">
            <div style="height: 100%; align-content: center;">
                <p style="" class="font-text-normal">
                    {{ $category->name }}
                </p>
            </div>
        </div>
    </div>
</a>


