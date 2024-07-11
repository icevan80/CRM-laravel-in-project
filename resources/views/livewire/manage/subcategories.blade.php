<div>
    <div class="w-1/3 float-right m-1">
        <x-widgets.search placeholder="Search Subcategories..."></x-widgets.search>
    </div>

    <x-table.default>
        <x-slot name="thead">
            <x-table.row>
                <x-table.column scope="col" class="">Id</x-table.column>
                <x-table.column scope="col" class="">Main category</x-table.column>
                <x-table.column scope="col" class="">Name</x-table.column>
                <x-table.column scope="col" class="">Presentation name</x-table.column>
                <x-table.column scope="col" class="">Full name</x-table.column>
                <x-table.column scope="col" class="w-0">Actions</x-table.column>
            </x-table.row>
        </x-slot>
        <x-slot name="tbody">

            @foreach ($subcategories as $subcategory)
                <x-table.row class="surface-color hover:bg-light-90 text-on-surface-color text-light-40 font-text-mini">
                    <x-table.column class="max-w-0">{{ $subcategory->id }}</x-table.column>

                    <x-table.column class="">{{ $subcategory->category->name}}</x-table.column>
                    <x-table.column class="">{{ $subcategory->name}}</x-table.column>
                    <x-table.column class="">{{ $subcategory->presentation_name}}</x-table.column>
                    <x-table.column class="">{{ $subcategory->full_name}}</x-table.column>

                    <x-table.column class="flex gap-4">

                        <x-button.default wire:click="confirmSubcategoryEdit({{ $subcategory->id }})">
                            {{ __('Edit') }}
                        </x-button.default>
                        <x-button.danger wire:click="confirmSubcategoryDeletion({{ $subcategory->id }})">
                            {{ __('Delete') }}
                        </x-button.danger>
                    </x-table.column>
                </x-table.row>
            @endforeach

        </x-slot>
    </x-table.default>
    <div class="px-2 py-1">
        {{ $subcategories->links() }}
    </div>

    <form action="{{route('manage.subcategories.update', ['id'=>$this->subcategoryId])}}" method="post">
        @csrf
        @method('PUT')
        <x-dialog.default wire:model="confirmEditSubcategory">
            <x-slot name="title">
                Изменение категории
            </x-slot>
            <x-slot name="content">
                <x-inputs.text label="{{ __('Subcategory name') }}" id="subcategory_name"
                               name="subcategory_name"></x-inputs.text>
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-button.default>
                        Сохранить
                    </x-button.default>
                    <x-button.secondary wire:click="$set('confirmEditSubcategory', false)">
                        Отмена
                    </x-button.secondary>
                </div>
            </x-slot>
        </x-dialog.default>
    </form>

    <form action="{{route('manage.subcategories.destroy', ['id' => $this->subcategoryId])}}" method="post">
        @csrf
        @method('PUT')
        <x-dialog.default wire:model="confirmDeleteSubcategory">
            <x-slot name="title">
                Удаление категории
            </x-slot>
            <x-slot name="content">
                Вы действительно хотите удалить эту категорию?
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-button.danger type="submit">
                        Удалить
                    </x-button.danger>
                    <x-button.secondary wire:click="$set('confirmDeleteSubcategory', false)">
                        Отмена
                    </x-button.secondary>
                </div>
            </x-slot>
        </x-dialog.default>
    </form>
</div>
