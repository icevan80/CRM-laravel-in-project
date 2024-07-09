<x-dashboard.shell>
    <div class="flex justify-between mx-2 pt-2">
        <h2 class="font-text-normal font-bold">Подкатегории</h2>
        <div x-data="{showCreateSubcategories: false}">
            <x-button.default x-on:click="showCreateSubcategories = true">
                Create
            </x-button.default>
            <form action="{{route('manage.subcategories.store')}}" method="post">
                @csrf
                @method('PUT')
                <x-dialog.default listener="showCreateSubcategories">
                    <x-slot name="title">
                        Создание новой подкатегории
                    </x-slot>
                    <x-slot name="content">
                        <x-inputs.text label="{{ __('Subcategory name') }}" type="text" id="subcategory_name" name="subcategory_name"></x-inputs.text>
                        <x-inputs.text label="{{ __('Presentation name') }}" type="text" id="subcategory_presentation_name" name="subcategory_presentation_name"></x-inputs.text>
                        <x-inputs.select label="{{ __('Rooted category') }}" id="category_id" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </x-inputs.select>
                    </x-slot>
                    <x-slot name="footer">
                        <div class="flex gap-3">
                            <x-button.default>
                                Сохранить
                            </x-button.default>
                            <x-button.secondary x-on:click="showCreateSubcategories = false">
                                Отмена
                            </x-button.secondary>
                        </div>
                    </x-slot>
                </x-dialog.default>
            </form>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-2">
        <livewire:manage.subcategories />
    </div>
</x-dashboard.shell>
