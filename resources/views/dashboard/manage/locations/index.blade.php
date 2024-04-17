<x-dashboard.shell>
    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Локации</h2>
        <div x-data="{showCreateLocations: false}">
            <x-button.default x-on:click="showCreateLocations = true"
                              class="px-2 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
                Create
            </x-button.default>
            <form action="{{route('manage.locations.store')}}" method="post">
                @csrf
                @method('PUT')
                <x-dialog.default listener="showCreateLocations">
                    <x-slot name="title">
                        Создание новой локации
                    </x-slot>
                    <x-slot name="content">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <x-input type="text" name="location_name" id="name" class="w-full"></x-input>
                            @error('location_name') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea type="text" name="location_address" id="address"
                                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm"></textarea>
                            @error('location_address') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="telephone_number" class="block text-sm font-medium text-gray-700">Telephone
                                Number</label>
                            <x-input type="tel" name="location_telephone_number" minlength="10" maxlength="10"
                                     id="telephone_number" class="w-full"></x-input>
                            @error('location_telephone_number') <span
                                class="text-red-500">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label for="location_operate" class="block text-sm font-medium text-gray-700">Is Operating</label>
                            <x-checkbox name="location_operate" id="location_operate"></x-checkbox>
                            @error('location_operate') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                    </x-slot>
                    <x-slot name="footer">
                        <div class="flex gap-3">
                            <x-button.default>
                                Сохранить
                            </x-button.default>
                            <x-button.secondary x-on:click="showCreateLocations = false">
                                Отмена
                            </x-button.secondary>
                        </div>
                    </x-slot>
                </x-dialog.default>
            </form>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5 p-4">
        <livewire:manage.locations/>
    </div>
</x-dashboard.shell>
