<x-dashboard.shell>
    <div class="flex justify-between mx-2 pt-2">
        <h2 class="font-text-normal font-bold">Менеджер ролей</h2>
        <div x-data="{showCreateRole: false}">
            <x-button.default x-on:click="showCreateRole = true">
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
                        <x-inputs.text label="{{ __('Role name') }}" id="role_name" name="role_name"></x-inputs.text>
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
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-2">
        <livewire:settings.roles :roles="$roles"/>
    </div>
</x-dashboard.shell>
