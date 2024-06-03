<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 error-color border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:error-color active:error-color focus:outline-none focus:ring-2 focus:error-color focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
