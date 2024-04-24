<div>
    <div class="w-1/3 float-right m-4">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <x-input type="search" wire:model.debounce.500ms="search" id="default-search" name="search"
                   class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Search Locations..."></x-input>
            <x-button.default type="submit" class="text-white absolute right-2.5 bottom-2.5 ">Search</x-button.default>
        </div>
    </div>

    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
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
                        <x-button wire:click="confirmLocationEdit({{ $location->id }}, {{ $location }})">
                            {{ __('Edit') }}
                        </x-button>


                        <x-danger-button wire:click="confirmLocationDeletion({{ $location->id }})">
                            {{ __('Delete') }}
                        </x-danger-button>
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
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <x-input type="text" name="location_name" id="name" class="w-full"
                                 value="{{$this->selectLocation->name}}"></x-input>
                        @error('location_name') <span
                            class="text-red-500">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="address"
                               class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea type="text" name="location_address" id="address"
                                  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">{{$this->selectLocation->address}}</textarea>
                        @error('location_address') <span
                            class="text-red-500">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="telephone_number" class="block text-sm font-medium text-gray-700">Telephone
                            Number</label>
                        <x-input type="tel" name="location_telephone_number" minlength="10"
                                 maxlength="10"
                                 id="telephone_number"
                                 value="{{$this->selectLocation->telephone_number}}"
                                 class="w-full"></x-input>
                        @error('location_telephone_number') <span
                            class="text-red-500">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="location_operate" class="block text-sm font-medium text-gray-700">Is
                            Operating</label>
                        <x-checkbox name="location_operate" id="location_operate"
                                    checkIt="{{$this->selectLocation->operate ? 'true' : 'false'}}"></x-checkbox>
                        @error('location_operate') <span
                            class="text-red-500">{{ $message }}</span>@enderror
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
