<div>
    <div class="w-1/3 float-right m-4">
        <x-widgets.search placeholder="Search Subcategories..."></x-widgets.search>
    </div>

    <table class="w-full border-collapse background-color text-left font-text-small text-gray-500 overflow-x-scroll min-w-screen">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Id</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Main category</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Name</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Presentation name</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Full name</th>
            <th scope="col" class="px-4 py-4 w-0 font-medium text-gray-900">Actions</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">

        @foreach ($subcategories as $subcategory)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-4  max-w-0">{{ $subcategory->id }}</td>

                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">{{ $subcategory->category->name}}</td>
                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">{{ $subcategory->name}}</td>
                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">{{ $subcategory->presentation_name}}</td>
                <td class="px-4 py-4 max-w-xs font-medium text-gray-700">{{ $subcategory->full_name}}</td>

                <td  class="px-4 py-4 max-w-xs font-medium text-gray-700">
                    <div class="flex gap-1">
                        <x-button.default wire:click="confirmSubcategoryEdit({{ $subcategory->id }})">
                            {{ __('Edit') }}
                        </x-button.default>
                        <x-button.danger wire:click="confirmSubcategoryDeletion({{ $subcategory->id }})">
                            {{ __('Delete') }}
                        </x-button.danger>
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="pl-6 pt-4">
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
                <x-inputs.text label="{{ __('Subcategory name') }}"  id="subcategory_name" name="subcategory_name"></x-inputs.text>
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
