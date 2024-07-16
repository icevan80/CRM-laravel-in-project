@php
    $store = getStore();
    $imageUrl= asset('images/salon/logo.png');
    if ($store['logo_url'] != null ) {
        $imageUrl= asset('storage/'.$store['logo_url']);
    }
@endphp

<div>
    <x-button.route href="{{ route('home') }}">
        <img src="{{ $imageUrl }}" alt="" class="">
    </x-button.route>
</div>
