@props(['disabled' => false])

<x-inputs.shell label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}"></x-inputs.shell>
<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' =>
        'border-primary-color border-paler-90 border-light-80 ring-primary-color
        font-text-small shadow-sm text-on-surface-color'
]) !!}>{{ $attributes['value'] }}</textarea>
<x-inputs.error for="{{ $attributes['id'] }}"></x-inputs.error>

