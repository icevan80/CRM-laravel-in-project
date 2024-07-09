@props(['disabled' => false])

<x-inputs.shell label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}"></x-inputs.shell>
<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' =>
        'border-primary-color border-paler-90 border-light-80 ring-primary-color
        font-text-small shadow-sm text-on-surface-color pl-2 pr-4'
        ]) !!}>
    {{ $slot }}
</select>
<x-inputs.error for="{{ $attributes['id'] }}"></x-inputs.error>
