<button {{ $attributes->merge(['type' => 'submit', 'class' =>
        'inline-flex items-center px-4 py-2 el-primary-color border border-transparent rounded-md font-semibold text-xs
        text-on-primary-color hover:el-darken-20 uppercase tracking-widest ring-primary-color
        focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
