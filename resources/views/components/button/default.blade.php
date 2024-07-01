<button {{ $attributes->merge(['type' => 'submit', 'class' =>
        'inline-flex items-center px-2 py-1 primary-color border border-transparent font-semibold font-text-small
        text-on-primary-color hover:bg-darken-20 focus:ring-2 focus:ring-offset-2 ring-primary-color
        focus:outline-none transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
