@props(['active'])

@php
    $baseClasses = 'relative flex flex-row items-center h-11 border-primary-color focus:outline-none
                    background-color font-text-normal
                    hover:bg-darken-10 text-on-surface-color  hover:text-darken-15 border-l-4 px-1
                    hover:border-opacity-100';
    $classes = ($active ?? false)
                ? $baseClasses.'  bg-darken-15 border-l-4 border-opacity-100 text-light-10 font-semibold'
                : $baseClasses.'  border-opacity-0 text-light-40';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
