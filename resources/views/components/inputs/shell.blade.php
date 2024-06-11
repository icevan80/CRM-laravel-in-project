@php
    $label = false;
    if($attributes['label']){
        $label = $attributes['label'];
    }
@endphp

@if($label)
    <x-inputs.label for="{{ $attributes['for'] }}">{{ $label }}</x-inputs.label>
@endif

<style>
    .ring-primary-color:focus{
        --tw-ring-opacity: 1;
        --ring-color-s: var(--primary-s);
        --ring-color-l: var(--primary-l);
        --tw-ring-color: hsl(var(--primary-h) var(--ring-color-s) var(--ring-color-l) / var(--tw-ring-opacity));
    }
    .border-primary-color:focus {
        --tw-border-opacity: 1;
        --border-color-s: var(--primary-s);
        --border-color-l: var(--primary-l);
        border-color: hsl(var(--primary-h) var(--border-color-s) var(--border-color-l) / var(--tw-border-opacity));
    }
</style>

