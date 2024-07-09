<div>
    <div class="w-1/3 float-right m-4">
        <x-widgets.search placeholder="Search Locations..."></x-widgets.search>
    </div>

    <table class="w-full border-collapse background-color text-left font-text-small text-gray-500 overflow-x-scroll min-w-screen">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Id</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Name</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900 w-full">Address</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Telephone Number</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Is Operating</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Actions</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">

        @foreach ($locations as $location)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-4  max-w-0">{{ $location->id }}</td>

                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">{{ $location->name}}</td>

                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">{{ $location->address}}</td>

                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">{{ $location->telephone_number}}</td>

                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">{{ $location->operate ? 'Yes' : 'No'}}</td>


                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">
                    <div class="flex gap-1">
                        <x-button.default wire:click="confirmLocationEdit({{ $location->id }}, {{ $location }})">
                            {{ __('Edit') }}
                        </x-button.default>


                        <x-button.danger wire:click="confirmLocationDeletion({{ $location->id }})">
                            {{ __('Delete') }}
                        </x-button.danger>
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <div class=" pl-6 pt-4
                        ">
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
                        <x-inputs.default label="Telephone Number" type="tel" name="location_telephone_number" minlength="10"
                                 maxlength="10"
                                 id="telephone_number"
                                 value="{{$this->selectLocation->telephone_number}}"
                                 class="w-full"></x-inputs.default>
                    </div>

                    <div class="my-2">
                        <x-inputs.checkbox label="{{ __('Is Operating') }}" name="location_operate" id="location_operate"
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
