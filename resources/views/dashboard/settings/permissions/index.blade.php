<x-dashboard.shell>
    <div class="flex justify-between mx-2 pt-2">
        <h2 class="font-text-normal font-bold">Менеджер прав</h2>
        <div x-data="{showCreatePermission: false}">
            <x-button.default x-on:click="showCreatePermission = true">
                Create
            </x-button.default>
            <form action="{{route('settings.permissions.store')}}" method="post">
                @csrf
                @method('PUT')
                <x-dialog.default listener="showCreatePermission">
                    <x-slot name="title">
                        Создание нового правила
                    </x-slot>
                    <x-slot name="content">
                        <x-inputs.text label="{{ __('Permission name') }}" id="permission_name" name="permission_name"></x-inputs.text>
                    </x-slot>
                    <x-slot name="footer">
                        <div class="flex gap-3">
                            <x-button.default>
                                Сохранить
                            </x-button.default>
                            <x-button.secondary x-on:click="showCreatePermission = false">
                                Отмена
                            </x-button.secondary>
                        </div>
                    </x-slot>
                </x-dialog.default>
            </form>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-1 p-1">
        <livewire:settings.permissions :permissions="$permissions"/>
    </div>
</x-dashboard.shell>
