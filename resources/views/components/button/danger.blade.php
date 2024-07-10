<button {{ $attributes->merge(['type' => 'button', 'class' =>
        'inline-flex items-center justify-center px-2 py-1 error-color border border-transparent
        font-semibold font-text-small text-on-error-color hover:bg-darken-20
        focus:outline-none focus:ring-2 ring-error-color focus:ring-offset-2 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
