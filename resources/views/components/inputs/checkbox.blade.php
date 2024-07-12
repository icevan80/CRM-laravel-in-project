@php
    $fontSize = 'font-text-small';
    if ($attributes['font-size']) {
        $fontSize = $attributes['font-size'];
    }
@endphp

<div class="flex">
    <input type="checkbox" {!! $attributes->merge(['class' =>
            'rounded text-primary-color border-primary-color
            border-primary-color border-paler-90 border-light-80 ring-primary-color shadow-sm w-8 h-8 rounded-t-none rounded-b-none'
            ]) !!} {{$attributes['checkIt'] == "true" ? 'checked' : ''}} style="margin: auto 0">
    <div class="px-1">
        <x-inputs.shell label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}" font-size="{{ $fontSize }}"></x-inputs.shell>
    </div>
</div>
