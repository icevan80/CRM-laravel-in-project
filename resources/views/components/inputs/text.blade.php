@props(['disabled' => false])

<x-inputs.shell label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}"></x-inputs.shell>
<input type="text" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' =>
        'border-primary-color border-dimmer-25 border-lighter-85 ring-primary-color
        rounded-md shadow-sm text-on-surface-color'
]) !!}>
<x-inputs.error for="{{ $attributes['id'] }}"></x-inputs.error>

