<div>
    <table
        class="w-full bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="pl-6 py-4 font-medium text-gray-900 border">Имя роли</th>
            <th scope="col" colspan="4" class="w-full px-4 py-4 font-medium text-gray-900 border">
                Кол-во привелегий
            </th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900 border">Статус</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900 border">Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            {{--            <div x-data="{showPermissions{{$role->id}}: false}">--}}
            <tr x-data="{showPermissions{{$role->id}}: false}">
                <th scope="col"
                    class="pl-6 py-4 font-medium text-gray-900 border">{{$role->name}}</th>
                <th scope="col" colspan="4"
                    class="w-full px-4 py-4 font-medium text-gray-900 border"><p
                        x-show="!showPermissions{{$role->id}}">{{count($role->permissions())}}</p>
                    <div x-show="showPermissions{{$role->id}}" class="w-full">
                        <h1>{{$role->id}}</h1>
                        <livewire:settings.permissions :permissions="$permissions" :role-id="$role->id"/>
                    </div>
                </th>
                <th scope="col"
                    class="px-4 py-4 font-medium text-gray-900 border">{{$role->status == 1 ? 'Активна' : 'Неактивна'}}</th>
                <th scope="col"
                    class="px-4 py-4 font-medium text-gray-900 border">
                    <x-button @click="showPermissions{{$role->id}} = !showPermissions{{$role->id}}"
                              wire:click="openRolePermissions({{$role}})">
                        <p> Показать привелегии</p>
                    </x-button>
                    <x-button x-show="showPermissions{{$role->id}}" wire:click="saveNewPermissions({{$role}})">
                        <p> Сохранить привелегии</p>
                    </x-button>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>

    <x-dialog-modal wire:model="notificationPermissionChanged">
        <x-slot name="title">
            Статус сохранения
        </x-slot>
        <x-slot name="content">
            <p>Привелегии по умолчанию для этой роли успешно изменены</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-3">
                <x-secondary-button wire:click="$set('notificationPermissionChanged', false)"
                                    wire:loading.attr="disabled">
                    Пон
                </x-secondary-button>
            </div>

        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="errorPermissionChanged">
        <x-slot name="title">
            Статус сохранения
        </x-slot>
        <x-slot name="content">
            <p>Привелегии по умолчанию для этой роли не были сохранены</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-3">
                <x-secondary-button wire:click="$set('errorPermissionChanged', false)"
                                    wire:loading.attr="disabled">
                    Пон
                </x-secondary-button>
            </div>

        </x-slot>
    </x-dialog-modal>
</div>
