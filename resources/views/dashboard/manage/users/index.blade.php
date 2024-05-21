<x-dashboard.shell>

    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Users</h2>
        <div>
            <a href="{{route('manage.users.create')}}">
                <x-button.default
                                  class="px-2 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
                    Create user
                </x-button.default>
            </a>
        </div>
    </div>
{{--    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5">--}}
{{--        <livewire:manage.users/>--}}
{{--    </div>--}}
</x-dashboard.shell>
