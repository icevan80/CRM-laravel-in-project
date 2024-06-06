<div x-data="{ editPermissions: false }">
    <div class="flex text-left">
        <div class="px-6">
            <x-button.default x-on:click="editPermissions = !editPermissions">
                <p>Edit permissions</p>
            </x-button.default>
        </div>
        <form action="{{ route('manage.users.updateRole', [$user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex">
            <div class="px-6">
                <x-button.default type="submit">
                    Изменить роль
                </x-button.default>
            </div>
            <div class="px-6">
                <select class="border text-gray-900  border-gray-300 rounded-lg"
                        wire:model="roleId" name="roleId">
                    @foreach ($this->roles as $role)
                        <option value={{$role->id}}>{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
            </div>
        </form>
    </div>

    <div x-show="editPermissions">
        <livewire:settings.permissions :user-id="$user->id"/>
    </div>
</div>
