<x-dashboard.shell>
    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Service - {{$service->name}}</h2>
        <div x-data="{showEditService: false}">
            <x-button.default x-on:click="showEditService = true"
                              class="px-2 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
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
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5 p-4">
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
                    class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span>
                        Hidden
                      </span>
            @else
                <span
                    class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
                        Visible
                        </span>
            @endif

        </div>
    </div>
</x-dashboard.shell>
