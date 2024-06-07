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
                            <div style="position: relative" class="flex text-left">
                                <h2 style="width: 50%;  " class="pl-6">{{$permission->name}}</h2>
                                <div style="margin-right: 0; align-content: end" class="flex">
                                    <x-inputs.radio
                                        wire:click="updateStatus('{{$permission->id}}')"
                                        wire:model="permissionsMap.{{$permission->id}}.status"
                                        value="allow"
                                        label="{{__('Allow')}}"></x-inputs.radio>
                                    <x-inputs.radio
                                        wire:click="updateStatus('{{$permission->id}}')"
                                        wire:model="permissionsMap.{{$permission->id}}.status"
                                        value="reject"
                                        label="{{__('Reject')}}"></x-inputs.radio>
                                    <x-inputs.radio
                                        wire:click="updateStatus('{{$permission->id}}')"
                                        wire:model="permissionsMap.{{$permission->id}}.status"
                                        value="default"
                                        label="Role
                                        ({{ $this->permissionsMap[$permission->id]['roleStatus'] == 'allow' ? 'Allow' : 'Reject' }})"></x-inputs.radio>
                                </div>
                            </div>
                        </td>
                    @else
                        <td>
                            <x-inputs.checkbox wire:click="updateStatus('{{$permission->id}}')"
                                               wire:model="permissionsMap.{{$permission->id}}.status"
                                               label="{{$permission->name}}"></x-inputs.checkbox>
                        </td>
                    @endif
                    @if($loop->index % $this->elementsInRow == $this->elementsInRow - 1 || $loop->last)
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>
