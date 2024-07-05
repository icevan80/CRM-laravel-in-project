@props([
/** @var \mixed */
'deal'
])

@php
    $dealPosition = 'deal-position-bottom-left';
    if($attributes['deal-position']) {
        $dealPosition = 'deal-position-'.strval($attributes['deal-position']);
    }
    $bg = "";
    $textPercents = "";
    $textConditions = "";
    if ($attributes['variant']) {
        if ($attributes['variant'] == '1') {
            $bg = 'images/temp/deal2.jpg';
            $textPercents = "15";
            $textConditions = "на первый сенас маникюра";
        } else if ($attributes['variant'] == '2') {
            $bg = 'images/temp/deal1.jpg';
            $textPercents = "20";
            $textConditions = "весь месяц на депиляцию ног";
        }
    }

@endphp

{{-- TODO надо приделать разборку deal и добавить на беке больше полей --}}
<div card-item-split-tag class="mx-2.5 bg-no-repeat bg-cover bg-center bg-no-repeat shadow-md duration-300 hover:scale-105 hover:shadow-lg cursor-pointer" style="aspect-ratio : 1 / 1; background-image: url({{asset( $bg )}})">
    <div class="w-full h-full relative on-surface-color bg-opacity-25">
        <div class="w-3/4 {{ $dealPosition }} p-3.5">
            <p class="secondary-font text-deal-percent-giant text-on-primary-color" style="">-{{ $textPercents }}%</p>
            <p class="text-deal-condition-giant font-bold text-on-primary-color" style="">{{ $textConditions }}</p>
        </div>
    </div>
</div>
