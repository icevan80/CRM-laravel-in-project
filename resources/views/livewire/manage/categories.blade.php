<div>
    <div class="w-1/3 float-right m-1">
        <x-widgets.search placeholder="Search Categories..."></x-widgets.search>
    </div>

    <x-table.default>
        <x-slot name="thead">
            <x-table.row>
                <x-table.column scope="col" class="">Id</x-table.column>
                <x-table.column scope="col" class="">Photo</x-table.column>
                <x-table.column scope="col" class="w-full">Name</x-table.column>
                <x-table.column scope="col" class="">Actions</x-table.column>
            </x-table.row>
        </x-slot>
        <x-slot name="tbody">
            @foreach ($categories as $category)
                <x-table.row class="surface-color hover:bg-light-90 text-on-surface-color text-light-40 font-text-mini">
                    <x-table.column class="max-w-0">{{ $category->id }}</x-table.column>
                    <x-table.column class="">
                        <div class="w-20 h-20">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="" class="w-20 h-20 object-cover">
                        </div>
                    </x-table.column>
                    <x-table.column class="">{{ $category->name}}</x-table.column>
                    <x-table.column class="flex gap-4">
                            <x-button.default wire:click="confirmCategoryEdit({{ $category }})">
                                {{ __('Edit') }}
                            </x-button.default>
                            <x-button.danger wire:click="confirmCategoryDeletion({{ $category->id }})">
                                {{ __('Delete') }}
                            </x-button.danger>
                    </x-table.column>
                </x-table.row>
            @endforeach
        </x-slot>
    </x-table.default>

    <div class="px-2 py-1">
        {{ $categories->links() }}
    </div>

    <form action="{{route('manage.categories.update', ['id'=>$this->categoryId])}}" method="post">
        @csrf
        @method('PUT')
        <x-dialog.default wire:model="confirmEditCategory">
            <x-slot name="title">
                Изменение категории
            </x-slot>
            <x-slot name="content">
                @if(isset($this->selectedCategory))
                    <x-inputs.text label="{{ __('Category name') }}" id="category_name" name="category_name"
                                   value="{{ $this->selectedCategory['name'] }}"></x-inputs.text>
                    <livewire:components.upload-photo :tag="'category_image'"
                                                      :source="$this->selectedCategory['image']"/>
                @endif
            </x-slot>
            <x-slot name="footer">
                <div class="flex gap-3">
                    <x-button.default>
                        Сохранить
                    </x-button.default>
                    <x-button.secondary wire:click="$set('confirmEditCategory', false)">
                        Отмена
                    </x-button.secondary>
                </div>
            </x-slot>
        </x-dialog.default>
    </form>

    <form action="{{route('manage.categories.destroy', ['id' => $this->categoryId])}}" method="post">
        @csrf
        @method('PUT')
        <x-dialog.default wire:model="confirmDeleteCategory">
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
                    <x-button.secondary wire:click="$set('confirmDeleteCategory', false)">
                        Отмена
                    </x-button.secondary>
                </div>
            </x-slot>
        </x-dialog.default>
    </form>
</div>
