<x-dashboard.shell>
    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Deals</h2>
        <div x-data="{showCreateDeals: false}">
            <x-button.default x-on:click="showCreateDeals = true" class="px-2 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
                Create
            </x-button.default>
            <form action="{{route('manage.deals.store')}}" method="post">
                @csrf
                @method('PUT')
                <x-dialog.default listener="showCreateDeals">
                    <x-slot name="title">
                        Создание новой категории
                    </x-slot>
                    <x-slot name="content">
                        <x-forms.create.deal>

                        </x-forms.create.deal>
                    </x-slot>
                    <x-slot name="footer">
                        <div class="flex gap-3">
                            <x-button.default>
                                Сохранить
                            </x-button.default>
                            <x-button.secondary x-on:click="showCreateDeals = false">
                                Отмена
                            </x-button.secondary>
                        </div>
                    </x-slot>
                </x-dialog.default>
            </form>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-4">
    <livewire:manage.deals />
    </div>
</x-dashboard.shell>
