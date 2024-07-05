@php
    $firstLetter =  mb_substr($attributes['title'], 0, 1);
    $otherText = mb_substr($attributes['title'], 1);
    $line = !($attributes['line'] && $attributes['line'] == 'false' ? true : false);
@endphp

{{--<div class="w-full">--}}
<div class="text-center">
    <div class="inline-block">

    <span class="secondary-font font-title-normal font-height-6">
        {{$firstLetter}}
    </span>
        <span class="primary-font font-title-small text-semilight" style="font-weight: 200;">
        {{$otherText}}
    </span>
        @if($line)
            <div class="primary-gradient-line w-full"></div>
        @endif
    </div>
</div>
