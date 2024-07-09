<x-dashboard.shell>
    <div class="w-1/3 mx-auto background-color rounded-lg p-2.5">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
        <form action="{{ route('manage.users.store')}}"  method="post">
        @csrf
        @method('PUT')
        <!-- Name -->
            <x-forms.create.user :roles="$roles"></x-forms.create.user>

            <div class="flex items-center justify-end mt-2">
                <x-button.default class="ml-2">
                    {{ __('Create User') }}
                </x-button.default>
            </div>
        </form>
    </div>

</x-dashboard.shell>
