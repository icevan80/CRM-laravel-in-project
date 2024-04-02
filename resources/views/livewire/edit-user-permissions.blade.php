<div x-data="{ editPermissions: false }">
    <div style="display: flex" class="text-left">
        {{--        <h1></h1>--}}
        <div class="px-6">
            <x-button @click="editPermissions = !editPermissions">
                <p>Edit permissions</p>
            </x-button>
        </div>
        <div class="px-6">
            <x-button x-show="editPermissions" wire:click="changeUserPermissions">
                <p>Сохранить</p>
            </x-button>
        </div>
        <div class="px-6">
            <form action="{{ route('users.updateRole', [$user->id, $this->roleId]) }}" method="POST">
                @csrf
                @method('PUT')
                <x-button type="submit">Изменить роль</x-button>
            </form>
        </div>
        <div class="px-6">
            <select class="border text-gray-900  border-gray-300 rounded-lg"
                    wire:model="roleId">
                @foreach ($this->roles as $role)
                    <option value={{$role->id}}>{{$role->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div x-show="editPermissions">
        <table class="w-full bg-white text-left text-sm overflow-x-scroll min-w-screen">
            @foreach($permissions as $permission)
                @if($loop->index % 3 == 0)
                    <tr>
                        @endif
                        <td>
                            <div style="display: flex; position: relative" class="text-left">
                                <h2 style="width: 50%;  "class="pl-6">{{$permission->name}}</h2>
                                <div style="margin-right: 0; align-content: end">
                                {{--                                <div class="text-right">--}}
                                <label>
                                    <x-input type="radio" wire:model="userPermissionsMap.{{$permission->id}}.status"
                                             value="allow"></x-input>
                                    Allow
                                </label>
                                <label>
                                    <x-input type="radio" wire:model="userPermissionsMap.{{$permission->id}}.status"
                                             value="reject"></x-input>
                                    Reject
                                </label>
                                <label>
                                    <x-input type="radio" wire:model="userPermissionsMap.{{$permission->id}}.status"
                                             value="default"></x-input>
                                                                        Role ({{ $this->userPermissionsMap[$permission->id]['roleStatus'] == 'allow' ? 'Allow' : 'Reject' }})
                                </label>
                                </div>
                            </div>
                        </td>
                        @if($loop->index % 3 == 2 || $loop->last)
                    </tr>
                @endif
            @endforeach
        </table>
    </div>

    <x-dialog-modal wire:model="notificationPermissionChanged">
        <x-slot name="title">
            Статус сохранения
        </x-slot>
        <x-slot name="content">
            <p>Привелегии по умолчанию для этого пользователя успешно изменены</p>
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
            <p>Привелегии по умолчанию для этого пользователя не были сохранены</p>
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
