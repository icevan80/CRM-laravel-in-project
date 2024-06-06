<button {{ $attributes->merge(['type' => 'button', 'class' =>
        'inline-flex items-center justify-center px-4 py-2 surface-color border border-transparent rounded-md
        font-semibold text-xs text-on-surface-color uppercase tracking-widest hover:bg-lighter-85
        focus:outline-none focus:ring-2 ring-surface-color focus:ring-offset-2 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
