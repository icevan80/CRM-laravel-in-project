<div>
    <table
        class="w-full bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen ">
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
                    <x-button.default
                        x-on:click="showPermissions{{$role->id}} = !showPermissions{{$role->id}}"
                        wire:click="buttonHidePermissions({{$role}})">
                        <p x-show="!showPermissions{{$role->id}}">Показать привелегии</p>
                        <p x-show="showPermissions{{$role->id}}">Скрыть привелегии</p>
                    </x-button.default>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
