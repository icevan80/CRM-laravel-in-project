<x-dashboard.shell>
    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Локации</h2>
        <div x-data="{showCreateLocations: false}">
            <x-button.default x-on:click="showCreateLocations = true">
                {{ __('Create') }}
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
                            <x-inputs.text label="{{ __('Name') }}" name="location_name" id="name" class="w-full"></x-inputs.text>
                        </div>

                        <div>
                            <x-inputs.textarea label="{{ __('Address') }}" name="location_address" id="address"
                                      class="w-full "></x-inputs.textarea>
                        </div>

                        <div>
                            <x-inputs.default label="{{ __('Telephone Number') }}" type="tel" name="location_telephone_number" minlength="10" maxlength="10"
                                     id="telephone_number" class="w-full"></x-inputs.default>
                        </div>

                        <div class="my-2">
                            <x-inputs.checkbox label="{{ __('Is Operating') }}" name="location_operate" id="location_operate"></x-inputs.checkbox>
                        </div>
                    </x-slot>
                    <x-slot name="footer">
                        <div class="flex gap-3">
                            <x-button.default>
                                {{ __('Save') }}
                            </x-button.default>
                            <x-button.secondary x-on:click="showCreateLocations = false">
                                {{ __('Cancel') }}
                            </x-button.secondary>
                        </div>
                    </x-slot>
                </x-dialog.default>
            </form>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-4">
        <livewire:manage.locations/>
    </div>
</x-dashboard.shell>
