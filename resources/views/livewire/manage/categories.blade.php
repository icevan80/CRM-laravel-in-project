<div>
    <div class="w-1/3 float-right m-4">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <x-input type="search" wire:model.debounce.500ms="search" id="default-search" name="search"
                     class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                     placeholder="Search Categories..."></x-input>
            <x-button.default type="submit" class="text-white absolute right-2.5 bottom-2.5 ">Search</x-button.default>
        </div>
    </div>

    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Id</th>
            <th scope="col" class="px-4 py-4 w-full font-medium text-gray-900">Name</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Actions</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">

        @foreach ($categories as $category)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-4  max-w-0">{{ $category->id }}</td>

                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">{{ $category->name}}</td>

                <td  class="px-4 py-4 max-w-xs font-medium text-gray-700">
                    <div class="flex gap-1">
                        <x-button.default wire:click="confirmCategoryEdit({{ $category->id }})">
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
                <x-inputs.label for="category_name">Имя категории</x-inputs.label>
                <x-input type="text" id="category_name" name="category_name"/>
                <x-input-error for="category_name" class="mt-2"/>
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
