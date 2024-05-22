<x-dashboard.shell>
    <div class="w-1/3 mx-auto bg-white rounded-lg p-5">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
        <form action="{{ route('manage.users.store')}}"  method="post">
        @csrf
        @method('PUT')
        <!-- Name -->
            <x-forms.create.user :roles="$roles"></x-forms.create.user>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Create User') }}
                </x-button>
            </div>
        </form>
    </div>

</x-dashboard.shell>
