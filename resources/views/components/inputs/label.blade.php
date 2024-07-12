@props(['value'])

@php
    $fontSize = 'font-text-small';
    if ($attributes['font-size']) {
        $fontSize = $attributes['font-size'];
    }
@endphp

<label {{ $attributes->merge(['class' =>
        $fontSize.' block font-medium text-on-surface-color text-light-30'
]) }}>
    {{ $value ?? $slot }}
</label>
