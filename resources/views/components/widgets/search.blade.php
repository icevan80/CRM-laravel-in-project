@php
    $placeholder = $attributes['placeholder'];
@endphp

<div>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
            <svg class="w-8 h-8 text-gray-500 dark:text-gray-400" aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </div>
        <x-inputs.default type="search" wire:model.debounce.500ms="search" id="default-search" name="search"
                          class="w-full p-2 pl-5"
                          placeholder="{{ $placeholder }}"></x-inputs.default>
        <x-button.default type="submit" class="absolute right-4 bottom-2.5">
            Search
        </x-button.default>
    </div>
</div>
