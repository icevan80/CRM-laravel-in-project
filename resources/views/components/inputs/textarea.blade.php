@props(['disabled' => false])

<x-inputs.shell label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}"></x-inputs.shell>
<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-primary-color focus:ring-primary-color rounded-md shadow-sm text-on-surface-color']) !!}>{{ $attributes['value'] }}</textarea>
