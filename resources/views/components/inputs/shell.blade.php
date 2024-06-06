@php
    $label = false;
    if($attributes['label']){
        $label = $attributes['label'];
    }
@endphp

@if($label)
    <x-inputs.label for="{{ $attributes['for'] }}">{{ $label }}</x-inputs.label>
@endif
{{--<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-primary-color focus:ring-primary-color rounded-md shadow-sm text-on-surface-color']) !!}>--}}

{{--<style>
    .border-primary-color{
        border-color: var(--primary-color);
    }

    .text-primary-color{
        color: var(--primary-color);
    }

    .focus\:border-primary-color:focus{
        border-color: var(--primary-color);
    }

    .focus\:ring-primary-color:focus {
        --tw-ring-color: var(--primary-color);
    }
</style>--}}
