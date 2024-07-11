<div>
    <div class="w-1/3 float-right m-1">
        <x-widgets.search placeholder="Search Services..."></x-widgets.search>
    </div>

    <x-table.default>
        <x-slot name="thead">
            <x-table.row>
                <x-table.column scope="col" class="">Id</x-table.column>
                <x-table.column scope="col" class="">Service</x-table.column>
                <x-table.column scope="col" class="">Photo</x-table.column>
                <x-table.column scope="col" class="w-full">Notes</x-table.column>
                <x-table.column scope="col" class="">Price</x-table.column>
                <x-table.column scope="col" class="">Category</x-table.column>
                <x-table.column scope="col" class="">Subcategory</x-table.column>
                <x-table.column scope="col" class="">Duration</x-table.column>
                <x-table.column scope="col" class="">Visibility</x-table.column>
                <x-table.column scope="col" class="">Actions</x-table.column>
            </x-table.row>
        </x-slot>
        <x-slot name="tbody">

            @foreach ($services as $service)
                <x-table.row class="surface-color hover:bg-light-90 text-on-surface-color text-light-40 font-text-mini">
                    <x-table.column class="">{{ $service->id }}</x-table.column>
                    <x-table.column class="">{{ $service->name}}</x-table.column>
                    <x-table.column class="">
                        <div class="">
                            <img src="{{ asset('storage/' . $service->image) }}" alt="" class="w-20 h-20 object-cover">
                        </div>
                    </x-table.column>
                    <x-table.column class="">{{ $service->notes }}</x-table.column>
                    <x-table.column class="">
                        <div
                            class="text-center">{{ $service->price }}
                            @if(isset($service->max_price))
                                - {{ $service->max_price }}
                            @endif
                        </div>
                    </x-table.column>
                    <x-table.column class="">
                        <div class="">{{ $service->category?->name}}</div>
                    </x-table.column>
                    <x-table.column class="">
                        <div class="">
                            @if($service->subcategory != null)
                                {{ $service->subcategory->name}}
                            @else
                                {{__('No')}}
                            @endif
                        </div>
                    </x-table.column>
                    <x-table.column class="">
                        <div class="">{{ intdiv($service->duration_minutes , 60)}}
                            h{{ $service->duration_minutes % 60}}m
                        </div>
                    </x-table.column>
                    <x-table.column class="">
                        <div>
                            @if($service->is_hidden == true)
                                <span
                                    class="inline-flex items-center gap-4 rounded-full error-color bg-darken-20 bg-paler-50 bg-lighter-90 bg-opacity-75  px-2 py-1 font-medium text-error-color text-darken-35">
                                <span class="h-4 w-4 rounded-full error-color"></span>
                            Hidden
                            </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-4 rounded-full success-color bg-darken-20 bg-lighter-90 bg-opacity-75  px-2 py-1 font-medium text-success-color text-darken-35">
                                <span class="h-4 w-4 rounded-full success-color"></span>
                            Visible
                            </span>
                            @endif
                        </div>
                    </x-table.column>
                    <x-table.column class="flex gap-4">
                        <x-button.route href="{{ route('manage.services.show', ['id' => $service->id ])  }}">
                            <x-button.default class="">
                                {{ __('View') }}
                            </x-button.default>
                        </x-button.route>
                        <x-button.default class="" wire:click="confirmingServiceEdition({{ $service->id }})">
                            {{ __('Edit') }}
                        </x-button.default>
                        <x-button.danger class="" wire:click="confirmServiceDeletion({{ $service->id }})"
                                         wire:loading.attr="disabled">
                            {{ __('Delete') }}
                        </x-button.danger>
                    </x-table.column>
                </x-table.row>
            @endforeach

        </x-slot>
    </x-table.default>

    <div class="px-2 py-1">
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
