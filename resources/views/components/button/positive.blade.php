<button {{ $attributes->merge(['type' => 'button', 'class' =>
        'inline-flex items-center justify-center px-4 py-2 el-success-color border border-transparent rounded-md
        font-semibold text-xs text-on-success-color uppercase tracking-widest hover:el-darken-20
        focus:outline-none focus:ring-2 ring-success-color focus:ring-offset-2 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
