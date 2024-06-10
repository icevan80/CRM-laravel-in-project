@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-primary-color text-left text-base font-medium text-primary-color text-lighter-50 primary-color bg-lighter-90 bg-opacity-75 focus:outline-none focus:text-darken-35 focus:bg-lighter-90 focus:border-darken-35 transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
