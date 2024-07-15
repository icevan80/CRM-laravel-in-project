<div>
    <x-table.default>
        <x-slot name="thead">

        <x-table.row>
            <x-table.column scope="col" class="border">Имя роли</x-table.column>
            <x-table.column scope="col" colspan="4" class="w-full border">
                Кол-во привелегий
            </x-table.column>
            <x-table.column scope="col" class="border">Статус</x-table.column>
            <x-table.column scope="col" class="border">Действия</x-table.column>
        </x-table.row>
        </x-slot>
        <x-slot name="tbody" class="font-text-mini">
        @foreach($roles as $role)
            <x-table.row x-data="{showPermissions{{$role->id}}: false}">
                <x-table.column scope="col"
                    class="border">
                    <p>
                        {{$role->name}}
                    </p>
                </x-table.column>
                <x-table.column scope="col"
                    colspan="4"
                    class="border">
                    <p x-show="!showPermissions{{$role->id}}">
                        {{count($role->permissions())}}
                    </p>
                    <div x-show="showPermissions{{$role->id}}">
                        <livewire:settings.permissions :permissions="$permissions" :role-id="$role->id"
                                                       :wire:key="$role->id"/>
                    </div>
                </x-table.column>
                <x-table.column scope="col"
                    class="border">
                    <p>
                        {{$role->status == 1 ? 'Активна' : 'Неактивна'}}
                    </p>
                </x-table.column>
                <x-table.column scope="col"
                    class="border">
                    <x-button.default
                        x-on:click="showPermissions{{$role->id}} = !showPermissions{{$role->id}}"
                        wire:click="buttonHidePermissions({{$role}})">
                        <p x-show="!showPermissions{{$role->id}}">Показать привелегии</p>
                        <p x-show="showPermissions{{$role->id}}">Скрыть привелегии</p>
                    </x-button.default>
                </x-table.column>
            </x-table.row>
        @endforeach
        </x-slot>
    </x-table.default>
</div>
