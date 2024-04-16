<div>
    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 overflow-x-scroll min-w-screen">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="pl-6 py-4 font-medium text-gray-900">Id</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Name</th>
            <th scope="col" class="px-4 py-4 font-medium text-gray-900">Actions</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 border-t border-gray-100">

        @foreach ($categories as $category)
            <tr class="hover:bg-gray-50">
                <td class="pl-6 py-4  max-w-0">{{ $category->id }}</td>

                <td class="px-6 py-4 max-w-xs font-medium text-gray-700">{{ $category->name}}</td>

                <td>
                    <div class="flex gap-1 mt-5">
                        <x-button wire:click="confirmCategoryEdit({{ $category->id }})" wire:loading.attr="disabled">
                            {{ __('Edit') }}
                        </x-button>



                        <x-danger-button wire:click="confirmCategoryDeletion({{ $category->id }})" wire:loading.attr="disabled">
                            {{ __('Delete') }}
                        </x-danger-button>
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
