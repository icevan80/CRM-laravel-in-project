<div>


    <table
        class="w-full bg-white text-left text-sm overflow-x-scroll min-w-screen">
        <tbody>
        @foreach($permissions as $permission)
            @if($loop->index % 4 == 0)
                <tr>
                    @endif
                    <td>
                        <div style="display: flex" class="text-left">
                            <x-checkbox wire:model="permissionsMap.{{$permission->id}}.status"></x-checkbox>
                            <h2 class="pl-6">{{$permission->name}}</h2>
                        </div>
                    </td>
                    @if($loop->last)
                        <td>
{{--                        <x-button wire:click="$set('createNewPermission', true)">--}}
                        <x-button wire:click="{{route('permissions.create')}}">
                            <p>Добавить</p>
                        </x-button>
                        </td>
                    @endif
                    @if($loop->index % 4 == 3 || $loop->last)
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
{{--    <form action="{{route('settings.permissions.create')}}" method="post">--}}
    <form action="" method="post">
        @csrf
    <x-dialog-modal wire:model="createNewPermission">
        <x-slot name="title">
            Создание нового правила
        </x-slot>
        <x-slot name="content">
            <x-label for="permission_name">Имя привелегии</x-label>
            <x-input type="text" id="permission_name" name="permission_name"/>
            <x-input-error for="permission_name" class="mt-2" />
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-3">
                <x-button>
                    Сохранить
                </x-button>
                <x-secondary-button wire:click="$set('createNewPermission', false)"
                                    wire:loading.attr="disabled">
                    Отмена
                </x-secondary-button>
            </div>

        </x-slot>
    </x-dialog-modal>
    </form>
</div>
