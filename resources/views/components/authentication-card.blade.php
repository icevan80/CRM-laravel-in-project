<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 primary-color bg-paler-50 bg-lighter-25 bg-opacity-75">
    <div>
        {{ $logo }}
    </div>

    <div class="w-1/3 mt-2 px-2 py-2 background-color bg-light-reset bg-saturation-reset shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
