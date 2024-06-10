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
        <header class="background-color shadow">
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
        --primary-variant-h: {{$theme['primary_variant_color']['h']}};
        --primary-variant-s: {{$theme['primary_variant_color']['s']}};
        --primary-variant-l: {{$theme['primary_variant_color']['l']}};
        --primary-h: {{$theme['primary_color']['h']}};
        --primary-s: {{$theme['primary_color']['s']}};
        --primary-l: {{$theme['primary_color']['l']}};
        --on-primary-h: {{$theme['on_primary_color']['h']}};
        --on-primary-s: {{$theme['on_primary_color']['s']}};
        --on-primary-l: {{$theme['on_primary_color']['l']}};
        --secondary-variant-h: {{$theme['secondary_variant_color']['h']}};
        --secondary-variant-s: {{$theme['secondary_variant_color']['s']}};
        --secondary-variant-l: {{$theme['secondary_variant_color']['l']}};
        --secondary-h: {{$theme['secondary_color']['h']}};
        --secondary-s: {{$theme['secondary_color']['s']}};
        --secondary-l: {{$theme['secondary_color']['l']}};
        --on-secondary-h: {{$theme['on_secondary_color']['h']}};
        --on-secondary-s: {{$theme['on_secondary_color']['s']}};
        --on-secondary-l: {{$theme['on_secondary_color']['l']}};
        --surface-h: {{$theme['surface_color']['h']}};
        --surface-s: {{$theme['surface_color']['s']}};
        --surface-l: {{$theme['surface_color']['l']}};
        --on-surface-h: {{$theme['on_surface_color']['h']}};
        --on-surface-s: {{$theme['on_surface_color']['s']}};
        --on-surface-l: {{$theme['on_surface_color']['l']}};
        --background-h: {{$theme['background_color']['h']}};
        --background-s: {{$theme['background_color']['s']}};
        --background-l: {{$theme['background_color']['l']}};
        --on-background-h: {{$theme['on_background_color']['h']}};
        --on-background-s: {{$theme['on_background_color']['s']}};
        --on-background-l: {{$theme['on_background_color']['l']}};
        --success-h: {{$theme['success_color']['h']}};
        --success-s: {{$theme['success_color']['s']}};
        --success-l: {{$theme['success_color']['l']}};
        --on-success-h: {{$theme['on_success_color']['h']}};
        --on-success-s: {{$theme['on_success_color']['s']}};
        --on-success-l: {{$theme['on_success_color']['l']}};
        --error-h: {{$theme['error_color']['h']}};
        --error-s: {{$theme['error_color']['s']}};
        --error-l: {{$theme['error_color']['l']}};
        --on-error-h: {{$theme['on_error_color']['h']}};
        --on-error-s: {{$theme['on_error_color']['s']}};
        --on-error-l: {{$theme['on_error_color']['l']}};
        --text-on-primary-h: {{$theme['text_on_primary_color']['h']}};
        --text-on-primary-s: {{$theme['text_on_primary_color']['s']}};
        --text-on-primary-l: {{$theme['text_on_primary_color']['l']}};
        --text-on-secondary-h: {{$theme['text_on_secondary_color']['h']}};
        --text-on-secondary-s: {{$theme['text_on_secondary_color']['s']}};
        --text-on-secondary-l: {{$theme['text_on_secondary_color']['l']}};
        --text-on-surface-h: {{$theme['text_on_surface_color']['h']}};
        --text-on-surface-s: {{$theme['text_on_surface_color']['s']}};
        --text-on-surface-l: {{$theme['text_on_surface_color']['l']}};
    }
</style>
