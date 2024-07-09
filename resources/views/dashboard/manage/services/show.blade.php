<x-dashboard.shell>
    <div class="flex justify-between mx-2 pt-2">
        <h2 class="font-text-normal font-bold">Service - {{$service->name}}</h2>
        <div x-data="{showEditService: false}">
            <x-button.default x-on:click="showEditService = true">
                Edit
            </x-button.default>
            <form action="{{route('manage.services.update', ['id'=> $id])}}" method="post">
                @csrf
                @method('PUT')
                <x-dialog.default listener="showEditService">
                    <x-slot name="title">
                        Редактирование услуги
                    </x-slot>

                    <x-slot name="content">
                        <x-forms.edit.service :categories="$categories" :masters="$masters" :service="$service"/>
                    </x-slot>

                    <x-slot name="footer">
                        <div class="flex gap-3">
                            <x-button.default>
                                Сохранить
                            </x-button.default>
                            <a href="{{route('manage.services')}}">
                                <x-button.secondary x-on:click="showEditService = false">
                                    Отмена
                                </x-button.secondary>
                            </a>
                        </div>
                    </x-slot>

                </x-dialog.default>
            </form>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-2 p-2">
        <div>

            {{ $service->name}}
        </div>


        <div class="w-20 h-20 font-medium text-gray-700">
            <img src="{{ asset('storage/' . $service->image) }}" alt="" class="w-20 h-20 object-cover">
        </div>

        <div>{{ $service->notes }}</div>

        <div
            class="font-medium text-gray-700">{{ $service->price }} @if(isset($service->max_price))
                - {{ $service->max_price }}@endif</div>
        <div class="font-medium text-gray-700">{{ $service->category?->name}}</div>
        <div class="font-medium text-gray-700">{{ intdiv($service->duration_minutes, 60)}}
            h{{ $service->duration_minutes % 60}}m
        </div>
        <div>
            @if($service->is_hidden == true)
                <span
                    class="inline-flex items-center gap-1 rounded-full error-color bg-lighter-90 bg-opacity-75 px-2 py-1 text-xs font-medium text-error-color">
                        <span class="h-1.5 w-1.5 rounded-full error-color"></span>
                        Hidden
                      </span>
            @else
                <span
                    class="inline-flex items-center gap-1 rounded-full success-color bg-lighter-90 bg-opacity-75 px-2 py-1 text-xs font-medium text-success-color">
                        <span class="h-1.5 w-1.5 rounded-full success-color"></span>
                        Visible
                        </span>
            @endif

        </div>
    </div>
</x-dashboard.shell>
