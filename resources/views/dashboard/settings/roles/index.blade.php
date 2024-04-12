<x-dashboard.shell>
    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Менеджер ролей</h2>
        <div x-data="{show: false}">
            <x-button x-on:click="show = true" class="px-2 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
                <p>Создать новую роль</p>
            </x-button>
            <form action="{{route('settings.roles.store')}}" method="post">
                @csrf
                @method('PUT')
                <x-dialog.default>
                    <x-slot name="title">
                        Создание новой роли
                    </x-slot>
                    <x-slot name="content">
                        <x-label for="role_name">Имя роли</x-label>
                        <x-input type="text" id="role_name" name="role_name"/>
                        <x-input-error for="role_name" class="mt-2"/>
                    </x-slot>
                    <x-slot name="footer">
                        <div class="flex gap-3">
                            <x-button>
                                Сохранить
                            </x-button>
                            <x-secondary-button x-on:click="show = false">
                                Отмена
                            </x-secondary-button>
                        </div>
                    </x-slot>
                </x-dialog.default>
            </form>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5">
        <livewire:settings.roles :roles="$roles"/>
    </div>
</x-dashboard.shell>
