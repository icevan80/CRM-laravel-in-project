@props(['active'])

@php
    $baseClasses = 'relative flex flex-row items-center h-11 border-primary-color focus:outline-none background-color
                    hover:bg-lighter-85 text-on-surface-color text-lighter-50 hover:text-darken-15 border-l-4 px-4
                    hover:border-opacity-100';
    $classes = ($active ?? false)
                ? $baseClasses.' bg-lighter-90 border-l-4 border-opacity-100 text-darken-15 font-semibold'
                : $baseClasses.' border-opacity-0';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
