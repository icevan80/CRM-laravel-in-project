<x-dashboard.shell>
    <div class="flex justify-between mx-2 pt-2">
        <h2 class="font-text-normal font-bold">Services</h2>

        <div x-data="{showCreateServices: false}">
                <x-button.default x-on:click="showCreateServices = true">
                    Create
                </x-button.default>
            <form action="{{route('manage.services.store')}}" method="post">
                @csrf
                @method('PUT')
                <x-dialog.default listener="showCreateServices">
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
                                <x-button.secondary x-on:click="showCreateServices = false">
                                    {{ __('Cancel') }}
                                </x-button.secondary>
                        </div>
                    </x-slot>

                </x-dialog.default>
            </form>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-2">
        <livewire:manage.services/>
    </div>
</x-dashboard.shell>
