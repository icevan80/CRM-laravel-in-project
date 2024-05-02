<x-dashboard.shell>


    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Services</h2>
        <div x-data="{showCreateServices: {{request()->routeIs('manage.services.create') ? 'true' : 'false'}}}">
            <a href="{{route('manage.services.create')}}">
                <x-button.default x-on:click="showCreateServices = true"
                                  class="px-2 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
                    Create
                </x-button.default>
            </a>
            <form action="{{route('manage.services.store')}}" method="post">
                @csrf
                @method('PUT')
                <x-dialog.default listener="showCreateServices" back-route="{{route('manage.services')}}">
                    <x-slot name="title">
                        Создание новой услуги
                    </x-slot>

                    <x-slot name="content">
                        <x-forms.create.service :categories="$categories" :masters="$masters"/>
                    </x-slot>

                    <x-slot name="footer">
                        <div class="flex gap-3">
                            <x-button.default>
                                Сохранить
                            </x-button.default>
                            <a href="{{route('manage.services')}}">
                                <x-button.secondary x-on:click="showCreateServices = false">
                                    Отмена
                                </x-button.secondary>
                            </a>
                        </div>
                    </x-slot>

                </x-dialog.default>
            </form>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5">
        <livewire:manage.services/>
    </div>
    @if(request()->routeIs('manage.services.edit'))
    <div x-data="{showEditService: {{request()->routeIs('manage.services.edit') ? 'true' : 'false'}}}">
        <form action="{{route('manage.services.update', ['id'=> $id])}}" method="post">
            @csrf
            @method('PUT')
            <x-dialog.default listener="showEditService" back-route="{{route('manage.services')}}">
                <x-slot name="title">
                    Создание новой услуги
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
    @endif
</x-dashboard.shell>
