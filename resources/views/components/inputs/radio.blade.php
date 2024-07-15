@php
    $fontSize = 'font-text-small';
    if ($attributes['font-size']) {
        $fontSize = $attributes['font-size'];
    }
@endphp

<div class="flex">
    <input
        type="radio" {!! $attributes->merge(['class' =>
        'rounded-full text-primary-color font-text-small border-primary-color w-8 h-8 border-paler-90 border-light-80 ring-primary-color shadow-sm'
        ]) !!} {{$attributes['checkIt'] == "true" ? 'checked' : ''}}>
    <div class="px-1">
        <x-inputs.shell label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}" font-size="{{ $fontSize }}"></x-inputs.shell>
    </div>
</div>
