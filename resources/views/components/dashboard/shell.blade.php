<x-app-layout>
{{--    <div style="position: relative;">--}}
    <div class="shell-grid">
        <div style="min-width: 200px">
            <x-dashboard.menu/>
        </div>
        <div class="w-full">
            {{-- TODO: Change notification message --}}
            @if (session('errormsg'))
                <div class="mb-4 font-medium text-sm text-red-600">
                    {{ session('errormsg') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="dashboard-content-slot">
                {{ $slot }}
            </div>
        </div>
    </div>

</x-app-layout>

<style>
    .shell-grid {
        display: grid;
        grid-template-columns: 2fr 15fr;
    }

    @media (max-width: 640px) {
        .shell-grid {
            display: block;
        }
        .dashboard-content-slot{
            margin-top: 64px;
        }
    }

</style>
