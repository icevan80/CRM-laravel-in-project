<x-dashboard.shell>
    <div class="flex justify-between  mx-2 pt-2">
        <h2 class="font-text-normal font-bold">Категории</h2>
        <div x-data="{showCreateCategories: false}">
            <x-button.default x-on:click="showCreateCategories = true">
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
                        <x-inputs.text label="{{ __('Category name') }}" type="text" id="category_name" name="category_name"></x-inputs.text>
                        <livewire:components.upload-photo :tag="'category_image'"/>
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
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-2">
        <livewire:manage.categories />
    </div>
</x-dashboard.shell>
