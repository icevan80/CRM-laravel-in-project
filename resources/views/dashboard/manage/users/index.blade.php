<x-dashboard.shell>

    <div class="flex justify-between mx-7 pt-6">
        @if(request()->routeIs('manage.users.clients'))
            <h2 class="text-2xl font-bold">Clients</h2>
        @elseif(request()->routeIs('manage.users.staff'))
            <h2 class="text-2xl font-bold">Staff</h2>
        @else
            <h2 class="text-2xl font-bold">All users</h2>
        @endif
        <div>
            <a href="{{route('manage.users.create')}}">
                <x-button.default>
                    Create user
                </x-button.default>
            </a>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-4">
        <livewire:manage.users/>
    </div>
</x-dashboard.shell>
