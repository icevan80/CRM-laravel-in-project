<div>
    <div class="w-1/3 float-right m-1">
        <x-widgets.search placeholder="Search Locations..."></x-widgets.search>
    </div>

    <x-table.default>
        <x-slot name="thead">
            <x-table.row>
                <x-table.column scope="col" class="">Id</x-table.column>
                <x-table.column scope="col" class="">Name</x-table.column>
                <x-table.column scope="col" class=" w-full">Address</x-table.column>
                <x-table.column scope="col" class="">Telephone Number</x-table.column>
                <x-table.column scope="col" class="">Is Operating</x-table.column>
                <x-table.column scope="col" class="">Actions</x-table.column>
            </x-table.row>
        </x-slot>
        <x-slot name="tbody">

            @foreach ($locations as $location)
                <x-table.row class="surface-color hover:bg-light-90 text-on-surface-color text-light-40 font-text-mini">
                    <x-table.column class="max-w-0">{{ $location->id }}</x-table.column>
                    <x-table.column class="">{{ $location->name}}</x-table.column>
                    <x-table.column class="">{{ $location->address}}</x-table.column>
                    <x-table.column class="">{{ $location->telephone_number}}</x-table.column>
                    <x-table.column class="">{{ $location->operate ? 'Yes' : 'No'}}</x-table.column>
                    <x-table.column class="flex gap-4">
                        <x-button.default wire:click="confirmLocationEdit({{ $location->id }}, {{ $location }})">
                            {{ __('Edit') }}
                        </x-button.default>


                        <x-button.danger wire:click="confirmLocationDeletion({{ $location->id }})">
                            {{ __('Delete') }}
                        </x-button.danger>
                    </x-table.column>
                </x-table.row>
            @endforeach

        </x-slot>
    </x-table.default>

    <div class="px-2 py-1">
        {{ $locations->links() }}
    </div>

    <form action="{{route('manage.locations.update', ['id'=>$this->locationId])}}" method="post">
        @csrf
        @method('PUT')
        <x-dialog.default wire:model="confirmEditLocation">
            <x-slot name="title">
                Изменение локации
            </x-slot>
            <x-slot name="content">
                @isset($this->selectLocation)
                    <div>
                        <x-inputs.text label="{{ __('Name') }}" name="location_name" id="name" class="w-full"
                                       value="{{$this->selectLocation->name}}"></x-inputs.text>
                    </div>

                    <div>
                        <x-inputs.textarea label="Address" name="location_address" id="address"
                                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:font-text-small">{{$this->selectLocation->address}}</x-inputs.textarea>
                    </div>

                    <div>
                        <x-inputs.default label="Telephone Number" type="tel" name="location_telephone_number"
                                          minlength="10"
                                          maxlength="10"
                                          id="telephone_number"
                                          value="{{$this->selectLocation->telephone_number}}"
                                          class="w-full"></x-inputs.default>
                    </div>

                    <div class="my-2">
                        <x-inputs.checkbox label="{{ __('Is Operating') }}" name="location_operate"
                                           id="location_operate"
                                           checkIt="{{$this->selectLocation->operate ? 'true' : 'false'}}"></x-inputs.checkbox>
                    </div>
                @endisset
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-button.default>
                        Сохранить
                    </x-button.default>
                    <x-button.secondary wire:click="$set('confirmEditLocation', false)">
                        Отмена
                    </x-button.secondary>
                </div>
            </x-slot>
        </x-dialog.default>
    </form>

    <form action="{{route('manage.locations.destroy', ['id' => $this->locationId])}}" method="post">
        @csrf
        @method('PUT')
        <x-dialog.default wire:model="confirmDeleteLocation">
            <x-slot name="title">
                Удаление локации
            </x-slot>
            <x-slot name="content">
                Вы действительно хотите удалить эту локацию?
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-button.danger type="submit">
                        Удалить
                    </x-button.danger>
                    <x-button.secondary wire:click="$set('confirmDeleteLocation', false)">
                        Отмена
                    </x-button.secondary>
                </div>
            </x-slot>
        </x-dialog.default>
    </form>
</div>
