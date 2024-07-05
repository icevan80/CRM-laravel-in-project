@props([
/** @var \mixed */
'master'
])
@php
    $dealPosition = 'deal-position-bottom-left';
    if($attributes['deal-position']) {
        $dealPosition = 'deal-position-'.strval($attributes['deal-position']);
    }

@endphp

{{-- TODO надо приделать разборку master и добавить на беке больше полей --}}
<div card-item-split-tag class="mx-3">
    <div class="w-full h-full">
        <div class="w-full secondary-variant-color rounded-full mb-2 shadow-md duration-300 hover:scale-105 hover:shadow-lg cursor-pointer" style="aspect-ratio : 1 / 1;">

        </div>
        <div class="">
            <p class="font-bold font-text-big" style="">Елена</p>
            <p class="font-weight-100 font-text-normal-plus" style="">Мастер маникюра и педикюра</p>
        </div>
    </div>
</div>

