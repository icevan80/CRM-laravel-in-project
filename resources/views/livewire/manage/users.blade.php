<div>
    <div class="w-1/3 float-right m-1">
        <x-widgets.search placeholder="Search Users..."></x-widgets.search>
    </div>
    <x-table.default>
        <x-slot name="thead">
            <x-table.row>
                <x-table.column scope="col" class="w-0">Id</x-table.column>
                <x-table.column scope="col" class="w-0">Avatar</x-table.column>
                <x-table.column scope="col" class="">Name</x-table.column>
                <x-table.column scope="col" class="">Email</x-table.column>
                <x-table.column scope="col" class="">Phone</x-table.column>
                <x-table.column scope="col" class="">Role</x-table.column>
                <x-table.column scope="col" class="w-0">Status</x-table.column>
                <x-table.column scope="col" class=""></x-table.column>
            </x-table.row>
        </x-slot>
        <x-slot name="tbody">
            @foreach ($users as $user)
                <x-table.row class="surface-color hover:bg-light-90 text-on-surface-color text-light-40 font-text-mini">
                    <x-table.column class="">{{ $user->id }}</x-table.column>
                    <x-table.column>
                        <div class="h-20 w-20">
                            <img alt="{{ $user->name }}'s avatar}}"
                                 class="h-full w-full rounded-full object-cover object-center"
                                 src={{ $user->profile_photo_url }}
                                     alt=""/>
                        </div>
                    </x-table.column>
                    <x-table.column class="">{{ $user->name }}</x-table.column>
                    <x-table.column class="">{{ $user->email }}</x-table.column>
                    <x-table.column class="">{{ $user->phone_number }}</x-table.column>
                    <x-table.column class="">{{ $user->role->name }}</x-table.column>
                    <x-table.column class="">
                        <div>
                            @if($user->status != true)
                                <span
                                    class="inline-flex items-center gap-4 rounded-full error-color bg-darken-20 bg-paler-50 bg-lighter-90 bg-opacity-75  px-2 py-1 font-medium text-error-color text-darken-35">
                                <span class="h-4 w-4 rounded-full error-color"></span>
                            Suspended
                            </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-4 rounded-full success-color bg-darken-20 bg-lighter-90 bg-opacity-75  px-2 py-1 font-medium text-success-color text-darken-35">
                                <span class="h-4 w-4 rounded-full success-color"></span>
                            Active
                            </span>
                            @endif
                        </div>
                    </x-table.column>
                    <x-table.column class="flex gap-4 float-right">
                        <x-button.route href="{{ route('manage.users.show', ['id' => $user->id ])  }}">
                            <x-button.default class="">
                                {{ __('View') }}
                            </x-button.default>
                        </x-button.route>
                        @if($user->status == true)
                            <x-button.danger class="" wire:click="confirmUserDeletion({{ $user->id }})"
                                             wire:loading.attr="disabled">
                                {{ __('Delete') }}
                            </x-button.danger>
                        @else
                            <x-button.positive class="" wire:click="confirmUserRestoration({{ $user->id }})"
                                               wire:loading.attr="disabled">
                                {{ __('Restore') }}
                            </x-button.positive>
                        @endif
                    </x-table.column>
                </x-table.row>
            @endforeach

        </x-slot>
    </x-table.default>
    <div class="px-2 py-1">
        {{ $users->links() }}
    </div>

    <form action="{{route('manage.users.destroy', ['id' => $this->confirmingUserDeletion])}}" method="post">
        @csrf
        @method('PUT')
        <x-dialog.default wire:model="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Deactivate user') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to deactivate user?') }}
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-button.danger type="submit">
                        Удалить
                    </x-button.danger>
                    <x-button.secondary wire:click="$set('$confirmingUserDeletion', false)">
                        Отмена
                    </x-button.secondary>
                </div>
            </x-slot>
        </x-dialog.default>
    </form>

    <form action="{{route('manage.users.restore', ['id' => $this->confirmingUserRestore])}}" method="post">
        @csrf
        @method('PUT')
        <x-dialog.default wire:model="confirmingUserRestore">
            <x-slot name="title">
                {{ __('Activate user') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to activate user?') }}
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-button.positive type="submit">
                        Восстановить
                    </x-button.positive>
                    <x-button.secondary wire:click="$set('$confirmingUserRestore', false)">
                        Отмена
                    </x-button.secondary>
                </div>
            </x-slot>
        </x-dialog.default>
    </form>
</div>
