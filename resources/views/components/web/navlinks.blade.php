{{-- Nav Links for the customer facing web --}}

<x-navlink.default href="{{ route('services') }}" :active="request()->routeIs('services')">
    {{ __('Services') }}
</x-navlink.default>

<x-navlink.default href="{{ route('deals') }}" :active="request()->routeIs('deals')">
    {{ __('Deals') }}
</x-navlink.default>
{{--
<x-nav-link href="{{ route('manageusers') }}" :active="request()->routeIs('manageusers')">
    {{ __('Manage Users') }}
</x-nav-link> --}}
