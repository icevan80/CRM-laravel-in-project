<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,400;0,500;1,300&display=swap" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased">
<x-banner/>

<div class="min-h-screen">
    <x-navlink.header-menu>

        <!-- Pass the main logo from page to the nav menu component-->
        <x-slot name="mainLogoRoute">
            @isset($mainLogoRoute)
                {{ $mainLogoRoute }}
            @endisset
        </x-slot>

        <!-- Pass the nav links from page to the nav menu component-->
        <x-slot name="navlinks">
            @isset($navlinks)
                {{ $navlinks }}
            @endif
        </x-slot>
    </x-navlink.header-menu>

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center">
                {{ $header }}
            </div>
        </header>
@endif

<!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>

@stack('modals')

@livewireScripts
</body>
</html>

@php
    // \Illuminate\Support\Facades\App::setLocale(getStore()->default_lang);
    $theme = getTheme();
@endphp


<style>
    :root {
        --primary-variant-color: {{$theme['primary_variant_color']}};
        --primary-color: {{$theme['primary_color']}};
        --primary-unselect-color: {{$theme['primary_unselect_color']}};
        --on-primary-color: {{$theme['on_primary_color']}};
        --secondary-variant-color: {{$theme['secondary_variant_color']}};
        --secondary-color: {{$theme['secondary_color']}};
        --secondary-unselect-color: {{$theme['secondary_unselect_color']}};
        --on-secondary-color: {{$theme['on_secondary_color']}};
        --surface-color: {{$theme['surface_color']}};
        --on-surface-color: {{$theme['on_surface_color']}};
        --background-color: {{$theme['background_color']}};
        --on-background-color: {{$theme['on_background_color']}};
        --success-color: {{$theme['success_color']}};
        --on-success-color: {{$theme['on_success_color']}};
        --error-color: {{$theme['error_color']}};
        --on-error-color: {{$theme['on_error_color']}};
        --text-on-primary-color: {{$theme['text_on_primary_color']}};
        --text-on-secondary-color: {{$theme['text_on_secondary_color']}};
        --text-on-surface-color: {{$theme['text_on_surface_color']}};
    }
</style>
