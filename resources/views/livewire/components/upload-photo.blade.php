<div>
    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
        <div class="col-span-2">
            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
            <input type="file" name="image" wire:model.defer="image" id="image" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('image') <span class="text-red-500">{{ $message }}</span>@enderror

            {{-- If the image is already saved is system show img --}}
            @if (isset($image) && is_string($image))
                <img alt="image" src="{{ '/storage/' . $image }}" class="mt-4" width="200">
                {{-- When the image is uploaded show img --}}
            @elseif (isset($image) && is_object($image))
                <img alt="image" src="{{ $image->temporaryUrl() }}" class="mt-4" width="200">
            @else

            @endif
        </div>
    </div>
</div>
