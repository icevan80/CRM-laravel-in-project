<a {{ $attributes->merge(['class' =>
                    'block w-full px-1 py-0.5 text-left font-text-small surface-color text-on-surface-color hover:bg-darken-20
                    focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out'
]) }}>
    {{ $slot }}
</a>
