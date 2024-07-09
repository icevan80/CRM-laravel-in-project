<div>
    <div class="w-1/3 float-right m-4">
        <x-widgets.search placeholder="Search Categories..."></x-widgets.search>

    </div>

    <table class="w-full border-collapse background-color text-left font-text-small text-gray-500 overflow-x-scroll min-w-screen">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Id</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Photo</th>
            <th scope="col" class="px-4 py-4 w-full font-medium text-gray-900">Name</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Actions</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">

        @foreach ($categories as $category)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-4  max-w-0">{{ $category->id }}</td>
                <td class="px-4 py-4">
                    <div class="w-20 h-20 font-medium text-gray-700">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="" class="w-20 h-20 object-cover">
                    </div>
                </td>
                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">{{ $category->name}}</td>

                <td  class="px-4 py-4 max-w-xs font-medium text-gray-700">
                    <div class="flex gap-1">
                        <x-button.default wire:click="confirmCategoryEdit({{ $category }})">
                            {{ __('Edit') }}
                        </x-button.default>
                        <x-button.danger wire:click="confirmCategoryDeletion({{ $category->id }})">
                            {{ __('Delete') }}
                        </x-button.danger>
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="pl-6 pt-4">
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
                <x-inputs.text label="{{ __('Category name') }}"  id="category_name" name="category_name" value="{{ $this->selectedCategory['name'] }}"></x-inputs.text>
                <livewire:components.upload-photo :tag="'category_image'" :source="$this->selectedCategory['image']"/>
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
