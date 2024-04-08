<x-app-layout>
    <div style="display: flex; position: relative">
        <x-dashboard.menu/>
        <div>
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

            <div class="dashboard-content-slot w-full">
                {{ $slot }}
            </div>
        </div>
    </div>

</x-app-layout>

<style>
    @media (max-width: 640px) {
        .dashboard-content-slot{
            margin-top: 64px;
        }
    }

</style>
