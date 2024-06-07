<x-dashboard.shell>
    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Менеджер ролей</h2>
        <div x-data="{showCreateRole: false}">
            <x-button.default x-on:click="showCreateRole = true" class="px-2 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
                <p>Создать новую роль</p>
            </x-button.default>
            <form action="{{route('settings.roles.store')}}" method="post">
                @csrf
                @method('PUT')
                <x-dialog.default listener="showCreateRole">
                    <x-slot name="title">
                        Создание новой роли
                    </x-slot>
                    <x-slot name="content">
                        <x-inputs.label for="role_name">Имя роли</x-inputs.label>
                        <x-input type="text" id="role_name" name="role_name"/>
                        <x-input-error for="role_name" class="mt-2"/>
                    </x-slot>
                    <x-slot name="footer">
                        <div class="flex gap-3">
                            <x-button.default>
                                Сохранить
                            </x-button.default>
                            <x-button.secondary x-on:click="showCreateRole = false">
                                Отмена
                            </x-button.secondary>
                        </div>
                    </x-slot>
                </x-dialog.default>
            </form>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-4">
        <livewire:settings.roles :roles="$roles"/>
    </div>
</x-dashboard.shell>
