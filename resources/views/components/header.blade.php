<div x-data="{ open: false }" class="w-full items-center header-menu background-color border-b z-50 sticky top-0">

    <div class="inline-flex float-left">
        <x-widgets.salon-logo></x-widgets.salon-logo>
        <x-widgets.salon-title></x-widgets.salon-title>
    </div>
    <div class="inline-flex float-right space-x-8">
        <div class="space-x-8">
            <x-navlink.header href="{{ route('home') }}" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-navlink.header>
            <x-navlink.header href="{{ route('services') }}" :active="request()->routeIs('services')">
                {{ __('Services') }}
            </x-navlink.header>

            <x-navlink.header href="{{ route('deals') }}" :active="request()->routeIs('deals')">
                {{ __('Deals') }}
            </x-navlink.header>

            @auth
                <x-navlink.header href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-navlink.header>
            @else
                <x-navlink.header href="{{ route('login') }}" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                </x-navlink.header>

                <x-navlink.header href="{{ route('register') }}" :active="request()->routeIs('register')">
                    {{ __('Register') }}
                </x-navlink.header>

            @endif

        </div>
        @auth

            {{--            <div class="items-center">--}}
            <x-widgets.dropdown align="right" width="48">
                <x-slot name="trigger">
                    <x-navlink.header class="cursor-pointer">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <img class="h-8 w-8 rounded-full object-cover"
                                 src="{{ Auth::user()->profile_photo_url }}"
                                 alt="{{ Auth::user()->name }}"/>
                        @endif
                        <div class="ml-2">
                            {{ Auth::user()->name }}
                        </div>
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </x-navlink.header>
                </x-slot>
                <x-slot name="content">
                    @if(auth()->user()->role->name == 'Customer')
                        <div class="block px-4 py-2 text-xs text-on-surface-color text-light-50">
                            {{ __('Shop') }}
                        </div>
                        <x-navlink.dropdown href="{{ route('cart') }}">
                            {{ __('Cart') }}
                        </x-navlink.dropdown>
                        <x-navlink.dropdown href="">
                            {{ __('Booking') }}
                        </x-navlink.dropdown>
                        <x-navlink.dropdown href="">
                            {{ __('My Appointments') }}
                        </x-navlink.dropdown>

                        <div class="border-t border-primary-color border-paler-90 border-light-80"></div>
                    @endif
                <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs text-on-surface-color text-light-50">
                        {{ __('Manage Account') }}
                    </div>

                    <x-navlink.dropdown href="{{ route('profile.show') }}">
                        {{ __('Profile') }}
                    </x-navlink.dropdown>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-navlink.dropdown href="{{ route('api-tokens.index') }}">
                            {{ __('API Tokens') }}
                        </x-navlink.dropdown>
                    @endif

                    <div class="border-t border-primary-color border-paler-90 border-light-80"></div>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-navlink.dropdown href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-navlink.dropdown>
                    </form>
                </x-slot>
            </x-widgets.dropdown>
        @endif
                <x-widgets.contact-header></x-widgets.contact-header>
    </div>
</div>

<style>
    .header-menu {
        padding: 32px 5%;
    }
</style>

