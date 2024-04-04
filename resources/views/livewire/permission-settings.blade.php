<div>
    {{-- Do your work, then step back. --}}
    <div style="display: flex" class="text-left">
        <h1 class="main-color-aboba">Менеджер прав</h1>
        <div class="px-6">
        <x-button wire:click="changePermissionsStatus">
            <p>Сохранить</p>
        </x-button>
        </div>
        <div class="px-6">
        <x-button wire:click="$set('createNewPermission', true)">
            <p>Добавить</p>
        </x-button>
    </div>
    </div>
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
                    @if($loop->index % 4 == 3 || $loop->last)
                </tr>
            @endif
        @endforeach
        </tbody>

    </table>
    <x-dialog-modal wire:model="createNewPermission">
        <x-slot name="title">
            Создание нового правила
        </x-slot>
        <x-slot name="content">
            <label>Имя привелегии</label>
            <x-input type="text" wire:model="newPermissionName">

            </x-input>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-3">
                <x-button wire:click="createNewPermission">
                    Сохранить
                </x-button>
                <x-secondary-button wire:click="$set('createNewPermission', false)"
                                    wire:loading.attr="disabled">
                    Отмена
                </x-secondary-button>
            </div>

        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model="notificationCreateStatus">
        <x-slot name="title">
            Статус создание
        </x-slot>
        <x-slot name="content">
            <p>Создано новое правило</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-3">
                <x-secondary-button wire:click="$set('notificationCreateStatus', false)"
                                    wire:loading.attr="disabled">
                    Пон
                </x-secondary-button>
            </div>

        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model="notificationSaveStatus">
        <x-slot name="title">
            Статус сохранения
        </x-slot>
        <x-slot name="content">
            <p>Все статусы правил были обновлены</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-3">
                <x-secondary-button wire:click="$set('notificationSaveStatus', false)"
                                    wire:loading.attr="disabled">
                    Пон
                </x-secondary-button>
            </div>

        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model="errorSaveStatus">
        <x-slot name="title">
            Статус сохранения
        </x-slot>
        <x-slot name="content">
            <p>Не все статусы правил были обновлены</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-3">
                <x-secondary-button wire:click="$set('notificationSaveStatus', false)"
                                    wire:loading.attr="disabled">
                    Пон
                </x-secondary-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
