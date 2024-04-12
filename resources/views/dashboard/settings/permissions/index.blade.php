<x-dashboard.shell>
    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Менеджер прав</h2>
        <div x-data="{showCreatePermission: false}">
            <x-button.default x-on:click="showCreatePermission = true" class="px-2 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
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
                        <x-label for="permission_name">Имя привелегии</x-label>
                        <x-input type="text" id="permission_name" name="permission_name"/>
                        <x-input-error for="permission_name" class="mt-2"/>
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
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5 p-4">
        <livewire:settings.permissions :permissions="$permissions"/>
    </div>
</x-dashboard.shell>
