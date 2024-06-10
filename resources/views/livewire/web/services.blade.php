<div class="background-color">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-10">
            <h1 class="text-4xl font-bold tracking-tight text-primary-color">Services</h1>
            <div class="w-1/3 float-right">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <x-inputs.default type="search" wire:model.debounce.500ms="search" id="default-search" name="search"
                                      class="w-full p-4 pl-10"
                             placeholder="Search Services..."></x-inputs.default>
                    <x-button.default type="submit" class="text-white absolute right-2.5 bottom-2.5 ">Search
                    </x-button.default>
                </div>
            </div>
        </div>
        <div class="flex">
            <div style="width: 25%" class="mr-4">
                <div x-data="{showCategory: true}">
                    <div class="pt-4" id="filter-section-1">
                        <h3 class="-my-3 flow-root">
                            <!-- Expand/collapse section button -->
                            <button type="button" x-on:click="showCategory=!showCategory"
                                    class="flex w-full items-center justify-between background-color py-3 text-sm text-gray-400 hover:text-gray-500"
                                    aria-controls="filter-section-1" aria-expanded="false">
                                <span class="font-medium text-gray-900">Category</span>
                                <span class="ml-6 flex items-center">
                                    <!-- Expand icon, show/hide based on section open state. -->
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      <path
                                          d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
                                    </svg>
                                    <!-- Collapse icon, show/hide based on section open state. -->
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      <path fill-rule="evenodd"
                                            d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                  </span>
                            </button>
                        </h3>
                        <div x-show="showCategory" class="my-4 space-y-4">
                            @foreach($categories as $category)
                                <div class="flex items-center">
                                    <input id="filter-category-{{ $category->id }}" wire:model="categoryFilter"
                                           value="{{ $category->id }}" type="checkbox"
                                           class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <label for="filter-category-{{ $category->id }}"
                                           class="ml-3 text-sm text-gray-600">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full">
                <div class="lg:col-span-3 flex flex-col flex-wrap pt-6 md:flex-row h-max">
                    @foreach ($services as $service)
                        @if($service->is_hidden == false)
                            <x-service-card :service="$service"/>
                        @endif
                    @endforeach
                    <div class="w-full">
                        <div class="flex justify-end mt-5 mx-2">
                            {{ $services->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
