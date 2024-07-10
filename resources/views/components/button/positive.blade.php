<button {{ $attributes->merge(['type' => 'button', 'class' =>
        'inline-flex items-center justify-center px-2 py-1 success-color border border-transparent
        font-semibold font-text-small text-on-success-color hover:bg-darken-20
        focus:outline-none focus:ring-2 ring-success-color focus:ring-offset-2 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
