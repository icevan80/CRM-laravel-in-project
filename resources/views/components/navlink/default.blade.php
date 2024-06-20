@props(['active'])

@php
    $baseClasses = 'inline-flex items-center px-1 py-0.5 border-b-2 font-text-normal font-medium border-primary-color text-on-surface-color focus:outline-none transition duration-150 ease-in-out';
    $classes = ($active ?? false)
                ? $baseClasses.' border-opacity-100 text-darken-15'
            : $baseClasses.' border-opacity-0 text-light-50 hover:text-darken-50 hover:border-opacity-75 hover:border-dimmer-25';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
