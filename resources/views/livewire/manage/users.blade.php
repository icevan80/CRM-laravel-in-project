<div>
    <div class="w-1/3 float-right m-4">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <x-inputs.default type="search" wire:model.debounce.500ms="search" id="default-search" name="search"
                     class="w-full p-4 pl-10"
                     placeholder="Search Users..."></x-inputs.default>
            <x-button.default type="submit" class="text-white absolute right-2.5 bottom-2.5 ">Search</x-button.default>
        </div>
    </div>
    <table class="w-full border-collapse background-color text-left font-text-small text-gray-500 overflow-x-scroll min-w-screen">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="w-0 px-4 py-4 font-medium text-gray-900">Id</th>
            <th scope="col" class="w-0 px-4 py-4 font-medium text-gray-900">Avatar</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Name</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Email</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Phone</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Role</th>
            <th scope="col" class="w-0 px-4 py-4 font-medium text-gray-900">Status</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900"></th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">

        @foreach ($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-4">
                    <div>
                        {{ $user->id }}
                    </div>
                </td>
                <th>
                    <div class="px-4">
                        <div class="h-10 w-10">
                            <img alt="{{ $user->name }}'s avatar}}"
                                 class="h-full w-full rounded-full object-cover object-center"
                                 src={{ $user->profile_photo_url }}
                                     alt=""/>
                        </div>
                    </div>
                </th>
                <td class="px-4 py-4">
                    <div>
                        {{ $user->name }}
                    </div>
                </td>
                <td class="px-4 py-4">
                    <div>
                        {{ $user->email }}
                    </div>
                </td>
                <td class="px-4 py-4">
                    <div>
                        {{ $user->phone_number }}
                    </div>
                </td>
                <td class="px-4 py-4">
                    <div>
                        {{ $user->role->name }}
                    </div>
                </td>
                <td class="px-4 py-4">
                    @if($user->status == true)
                        <span
                            class="inline-flex items-center gap-1 rounded-full success-color bg-lighter-90 bg-opacity-75  px-2 py-1 text-xs font-medium  text-success-color">
                        <span class="h-1.5 w-1.5 rounded-full success-color"></span>
                        Active
                      </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1 rounded-full error-color bg-lighter-90 bg-opacity-75 px-2 py-1 text-xs font-medium text-error-color">
                        <span class="h-1.5 w-1.5 rounded-full error-color"></span>
                        Suspended
                      </span>
                    @endif
                </td>


                <td class="px-4 py-4">
                    <div class="float-right">
                        <a href="{{ route('manage.users.show', ['id' => $user->id ])  }}">
                            <x-button.default class="ml-2">
                                {{ __('View') }}
                            </x-button.default>
                        </a>
                        @if($user->status == true)
                            <x-button.danger class="ml-2" wire:click="confirmUserDeletion({{ $user->id }})"
                                             wire:loading.attr="disabled">
                                {{ __('Delete') }}
                            </x-button.danger>
                        @else
                            <x-button.positive class="ml-2" wire:click="confirmUserRestoration({{ $user->id }})"
                                               wire:loading.attr="disabled">
                                {{ __('Restore') }}
                            </x-button.positive>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class=" pl-6 pt-4">
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
