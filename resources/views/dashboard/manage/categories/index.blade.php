<x-dashboard.shell>
    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Категории</h2>
        <div x-data="{showCreateCategories: false}">
            <x-button.default x-on:click="showCreateCategories = true" class="px-2 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
                Create
            </x-button.default>
            <form action="{{route('manage.categories.store')}}" method="post">
                @csrf
                @method('PUT')
                <x-dialog.default listener="showCreateCategories">
                    <x-slot name="title">
                        Создание новой категории
                    </x-slot>
                    <x-slot name="content">
                        <x-label for="category_name">Имя категории</x-label>
                        <x-input type="text" id="category_name" name="category_name"/>
                        <x-input-error for="category_name" class="mt-2"/>
                    </x-slot>
                    <x-slot name="footer">
                        <div class="flex gap-3">
                            <x-button.default>
                                Сохранить
                            </x-button.default>
                            <x-button.secondary x-on:click="showCreateCategories = false">
                                Отмена
                            </x-button.secondary>
                        </div>
                    </x-slot>
                </x-dialog.default>
            </form>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5 p-4">
        <livewire:manage.categories />
    </div>
</x-dashboard.shell>
