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
                     placeholder="Search Services..."></x-inputs.default>
            <x-button.default type="submit" class="text-white absolute right-2.5 bottom-2.5 ">Search</x-button.default>
        </div>
    </div>

    <table class="w-full border-collapse background-color text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Id</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Service</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Photo</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Notes</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Price</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Category</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Subcategory</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Duration</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Visibility</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Actions</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">

        @foreach ($services as $service)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-4">{{ $service->id }}</td>

                <td class="gap-3 px-4 py-4 font-medium text-gray-700 text-gray-900">

                    {{ $service->name}}

                </td>
                <td class="px-4 py-4">
                    <div class="w-20 h-20 font-medium text-gray-700">
                        <img src="{{ asset('storage/' . $service->image) }}" alt="" class="w-20 h-20 object-cover">
                    </div>
                </td>

                <td class="px-4 py-4 w-full">{{ $service->notes }}</td>

                <td class="px-4 py-4 ">
                    <div
                        class="font-medium text-center text-gray-700">{{ $service->price }} @if(isset($service->max_price))
                            - {{ $service->max_price }}@endif</div>
                </td>
                <td class="px-4 py-4">
                    <div class="font-medium text-gray-700">{{ $service->category?->name}}</div>
                </td>
                <td class="px-4 py-4">
                    <div class="font-medium text-gray-700">
                        @if($service->subcategory != null)
                            {{ $service->subcategory->name}}
                        @else
                            {{__('No')}}
                        @endif
                    </div>
                </td>
                <td class="px-4 py-4">
                    <div class="font-medium text-gray-700">{{ intdiv($service->duration_minutes , 60)}}
                        h{{ $service->duration_minutes % 60}}m
                    </div>
                </td>
                <td class="px-4 py-4 ">
                    <div>
                        @if($service->is_hidden == true)
                            <span
                                class="inline-flex items-center gap-1 rounded-full error-color bg-paler-50 bg-lighter-70 opacity-75 px-2 py-1 text-xs font-medium text-error-color"
                            >
                        <span class="h-1.5 w-1.5 rounded-full error-color"></span>
                        Hidden
                      </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 rounded-full success-color bg-paler-50 bg-lighter-70 opacity-75 px-2 py-1 text-xs font-medium text-success-color"
                            >
                        <span class="h-1.5 w-1.5 rounded-full success-color"></span>
                        Visible
                        </span>
                        @endif

                    </div>
                </td>
                <td>
                    <div class="mt-5 ">
                        <a href="{{ route('manage.services.show', ['id' => $service->id ])  }}">
                            <x-button.default class="m-2">
                                {{ __('View') }}
                            </x-button.default>

                        </a>
                        <x-button.default class="m-2" wire:click="confirmingServiceEdition({{ $service->id }})">
                            {{ __('Edit') }}
                        </x-button.default>
                        <x-button.danger class="m-2" wire:click="confirmServiceDeletion({{ $service->id }})"
                                         wire:loading.attr="disabled">
                            {{ __('Delete') }}
                        </x-button.danger>
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <div class=" pl-6 pt-4">
        {{ $services->links() }}
    </div>


    <form action="{{route('manage.services.destroy', ['id' => $confirmingServiceDeletion])}}" method="post">
        @csrf
        @method('PUT')
        <x-dialog.default wire:model="confirmingServiceDeletion">
            <x-slot name="title">
                {{ __('Delete Service') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete the service?') }}
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-button.danger type="submit">
                        Удалить
                    </x-button.danger>
                    <x-button.secondary wire:click="$set('confirmDeleteCategory', false)">
                        Отмена
                    </x-button.secondary>
                </div>
            </x-slot>
        </x-dialog.default>
    </form>

    <form action="{{route('manage.services.update', ['id'=> $confirmingServiceEdition])}}" method="post">
        @csrf
        @method('PUT')
        <x-dialog.default wire:model="confirmingServiceEdition">
            <x-slot name="title">
                Редактирование услуги
            </x-slot>

            <x-slot name="content">
                @isset($this->selectedService)
                    <x-forms.edit.service :categories="$categories" :masters="$masters"
                                          :service="$this->selectedService"/>
                @endif
            </x-slot>

            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-button.default>
                        Сохранить
                    </x-button.default>
                    <a href="{{route('manage.services')}}">
                        <x-button.secondary wire:click="$set('confirmingServiceEdition', false)">
                            {{ __('Cancel') }}
                        </x-button.secondary>
                    </a>
                </div>
            </x-slot>

        </x-dialog.default>
    </form>
</div>
