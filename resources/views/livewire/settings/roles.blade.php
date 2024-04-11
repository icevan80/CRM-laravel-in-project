<div>
    <x-button wire:click="$set('createNewRole', true)">
        <p>Создать новую роль</p>
    </x-button>
    <table
        class="w-full bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
        <thead class="bg-gray-50">

        <tr>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900 border">Имя роли</th>
            <th scope="col" colspan="4" class="w-full px-4 py-4 font-medium text-gray-900 border">
                Кол-во привелегий
            </th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900 border">Статус</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900 border">Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr x-data="{showPermissions{{$role->id}}: false}">
                <th scope="col"
                    class="px-4 py-4 font-medium text-gray-900 border">
                    <p>
                        {{$role->name}}
                    </p>
                </th>
                <th scope="col"
                    colspan="4"
                    class="px-4 py-4 font-medium text-gray-900 border">
                    <p x-show="!showPermissions{{$role->id}}">
                        {{count($role->permissions())}}
                    </p>
                    <div x-show="showPermissions{{$role->id}}">
                        <livewire:settings.permissions :permissions="$permissions" :role-id="$role->id"
                                                       :wire:key="$role->id"/>
                    </div>
                </th>
                <th scope="col"
                    class="px-4 py-4 font-medium text-gray-900 border">
                    <p>
                        {{$role->status == 1 ? 'Активна' : 'Неактивна'}}
                    </p>
                </th>
                <th scope="col"
                    class="px-4 py-4 font-medium text-gray-900 border">
                    <x-button
                        x-on:click="showPermissions{{$role->id}} = !showPermissions{{$role->id}}"
                        wire:click="buttonHidePermissions({{$role}})">
                        <p x-show="!showPermissions{{$role->id}}">Показать привелегии</p>
                        <p x-show="showPermissions{{$role->id}}">Скрыть привелегии</p>
                    </x-button>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
    <form action="{{route('settings.roles.store')}}" method="post">
        @csrf
        @method('PUT')
        <x-dialog-modal wire:model="createNewRole">
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
                    <x-button type="submit">
                        Сохранить
                    </x-button>
                    <x-secondary-button wire:click="$set('createNewRole', false)"
                                        wire:loading.attr="disabled">
                        Отмена
                    </x-secondary-button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </form>
</div>
