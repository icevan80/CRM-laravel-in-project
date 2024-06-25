@props([
/** @var \mixed */
'category'
])

@php
    $cardHeight = $attributes['height'].'px';
    $paddingTop = (($attributes['height'] - 40) / 2).'px';
@endphp

<a href=""
    {{ $attributes->class([
    'm-2.5 w-full primary-gradient-border pb-20 transform overflow-hidden
    background-color shadow-md duration-300 hover:scale-105 hover:shadow-lg'
    ]) }}
    style="height:{{ $cardHeight }};">
    <div class="grid grid-cols-5 h-inherit">
        <div class="grid-group-1/4">
            <div
                style="height:100%; width:100%; background-image: url('https://kartinki.pics/uploads/posts/2022-02/1645500476_1-kartinkin-net-p-kvadratnie-kartinki-1.jpg')">
            </div>
        </div>
        <div class="background-color border-margin grid-group-4/6">
            <div style="padding-top: {{ $paddingTop }}">
                <p style="" class="font-text-normal">
                    {{ $category->name }}
                </p>
            </div>
        </div>
    </div>
</a>


