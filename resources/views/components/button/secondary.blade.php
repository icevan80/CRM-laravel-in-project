<button {{ $attributes->merge(['type' => 'button', 'class' =>
        'inline-flex items-center justify-center px-4 py-2 surface-color border rounded-md
        font-semibold text-xs text-on-surface-color uppercase tracking-widest hover:bg-darken-20 ring-primary-color
        focus:outline-none focus:ring-2 ring-surface-color focus:ring-offset-2 transition ease-in-out duration-150
        border-primary-color border-paler-90 border-light-80'
]) }}>
    {{ $slot }}
</button>
