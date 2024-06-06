<div>
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="deal_name" id="name"
               class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
        @error('deal_name') <span class="text-red-500">{{ $message }}</span>@enderror
    </div>
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <input type="text" name="deal_description" id="description"
               class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
        @error('deal_description') <span class="text-red-500">{{ $message }}</span>@enderror
    </div>

    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700">Date Start</label>
            <input type="date" name="deal_start_date" id="start_date"
                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
            @error('deal_start_date') <span class="text-red-500">{{ $message }}</span>@enderror
        </div>
        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700">Date End</label>
            <input type="date" name="deal_end_date" id="end_date"
                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
            @error('deal_end_date') <span class="text-red-500">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
        <div>
            <label for="discount" class="block text-sm font-medium text-gray-700">Discount Percentage</label>
            <input type="number" name="deal_discount" id="discount"
                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
            @error('deal_discount') <span class="text-red-500">{{ $message }}</span>@enderror
        </div>
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <label for="is_hidden" class="block text-sm font-medium text-gray-700">Is Hidden</label>
                <input type="checkbox" name="deal_is_hidden" id="is_hidden"
                       class="block w-5 h-5 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                @error('deal_is_hidden') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div>
            </div>
        </div>
        <div class="flex justify-end mt-4 gap-2">

            <x-button.secondary wire:click="$set('confirmingDealAdd', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-button.secondary>
            <x-button.default wire:click="saveDeal">
                Save
            </x-button.default>
        </div>
    </div>
</div>
