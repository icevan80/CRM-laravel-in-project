@props(['disabled' => false])

<x-inputs.shell label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}"></x-inputs.shell>
<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' =>
        'border-primary-color border-dimmer-25 border-lighter-85 ring-primary-color rounded-md shadow-sm text-on-surface-color'
        ]) !!}>
    {{ $slot }}
</select>

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

{{--<style>--}}
{{--    .testik:focus {--}}
{{--        --border-color-s: 100;--}}
{{--    }--}}
{{--</style>--}}
