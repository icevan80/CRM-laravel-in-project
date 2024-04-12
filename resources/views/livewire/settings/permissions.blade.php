<div>
    <table
        class="w-full bg-white text-left text-sm overflow-x-scroll min-w-screen">
        <tbody>
        @foreach($permissions as $permission)
            @if($loop->index % $this->elementsInRow == 0)
                <tr>
                    @endif
                    @if($this->userId != null)
                        <td>
                            <div style="display: flex; position: relative" class="text-left">
                                <h2 style="width: 50%;  " class="pl-6">{{$permission->name}}</h2>
                                <div style="margin-right: 0; align-content: end">
                                    <label>
                                        <x-input type="radio" wire:model="permissionsMap.{{$permission->id}}.status"
                                                 value="allow"></x-input>
                                        Allow
                                    </label>
                                    <label>
                                        <x-input type="radio" wire:model="permissionsMap.{{$permission->id}}.status"
                                                 value="reject"></x-input>
                                        Reject
                                    </label>
                                    <label>
                                        <x-input type="radio" wire:model="permissionsMap.{{$permission->id}}.status"
                                                 value="default"></x-input>
                                        Role
                                        ({{ $this->permissionsMap[$permission->id]['roleStatus'] == 'allow' ? 'Allow' : 'Reject' }})
                                    </label>
                                </div>
                            </div>
                        </td>
                    @else
                        <td>
                            <div style="display: flex" class="text-left">
                                <x-checkbox wire:click="updateStatus('{{$permission->id}}')"
                                            wire:model="permissionsMap.{{$permission->id}}.status"></x-checkbox>
                                <h2 class="pl-6">{{$permission->name}}</h2>
                            </div>
                        </td>
                    @endif
                    @if($loop->index % $this->elementsInRow == $this->elementsInRow - 1 || $loop->last)
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>
