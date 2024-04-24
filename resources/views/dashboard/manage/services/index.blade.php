<x-dashboard.shell>


    <div class="flex justify-between mx-7 pt-6">
        <h2 class="text-2xl font-bold">Services</h2>
        <div x-data="{showCreateServices: {{request()->routeIs('manage.services.create') ? 'true' : 'false'}}}">
            <a href="{{route('manage.services.create')}}">
                <x-button.default x-on:click="showCreateServices = true"
                                  class="px-2 py-2 text-white bg-pink-500 rounded-md hover:bg--600">
                    Create
                </x-button.default>
            </a>
            <form action="{{route('manage.services.store')}}" method="post">
                @csrf
                @method('PUT')
                <x-dialog.default listener="showCreateServices" back-route="{{route('manage.services')}}">
                    <x-slot name="title">
                        Создание новой услуги
                    </x-slot>

                    <x-slot name="content">


                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <x-input type="text" name="service_name" id="name" class="w-full"></x-input>
                            @error('service_name') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea type="text" id="description" name="service_description"
                                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            @error('service_description') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                <x-input type="text" name="service_price" id="price" class="w-full"></x-input>
                                @error('service_price') <span class="text-red-500">{{ $message }}</span>@enderror

                            </div>

                            <div>
                                <label for="category_id"
                                       class="block text-sm font-medium text-gray-700">Category</label>

                                <select name="service_category_id" id="category_id"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option disabled selected value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name}}</option>
                                    @endforeach
                                    @error('service_category_id') <span
                                        class="text-red-500">{{ $message }}</span>@enderror
                                </select>
                            </div>

                            {{--                        <div>--}}
                            {{--                            <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Duration</label>--}}

                            {{--                            <select name="service_duration_minutes" id="duration_minutes" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">--}}

                            {{--                                    <option disabled selected value="">Select Duration</option>--}}
                            {{--                                    @for ($hours = 0; $hours <= 3; $hours++)--}}
                            {{--                                        @for ($minutes = 15; $minutes <= 45; $minutes += 15)--}}
                            {{--                                            <option value="{{ ($hours * 60) + $minutes }}">{{ $hours > 0 ? $hours . 'h ' : '' }}{{ $minutes }} min</option>--}}
                            {{--                                        @endfor--}}
                            {{--                                    @endfor--}}
                            {{--                                @error('service_duration_minutes') <span class="text-red-500">{{ $message }}</span>@enderror--}}
                            {{--                            </select>--}}
                            {{--                        </div>--}}
                        </div>
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label for="allergens" class="block text-sm font-medium text-gray-700">Allergens</label>
                                <textarea id="allergens" name="service_allergens"
                                          class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('service_allergens') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label for="cautions" class="block text-sm font-medium text-gray-700">Cautions</label>
                                <textarea id="cautions" name="service_cautions"
                                          class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('service_cautions') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label for="benefits" class="block text-sm font-medium text-gray-700">Benefits</label>
                                <textarea id="benefits" name="service_benefits"
                                          class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('service_benefits') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label for="aftercare_tips" class="block text-sm font-medium text-gray-700">Aftercare
                                    Tips</label>
                                <textarea id="aftercare_tips" name="service_aftercare_tips"
                                          class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                @error('service_aftercare_tips') <span
                                    class="text-red-500">{{ $message }}</span>@enderror
                            </div>

                        </div>
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea id="notes" name="service_notes"
                                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            @error('service_notes') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label for="is_hidden" class="block text-sm font-medium text-gray-700">Is Hidden</label>

                            <input type="checkbox" name="service_is_hidden" id="is_hidden">
                            @error('service_is_hidden') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>

{{--                        <livewire:components.image/>--}}
                        <livewire:components.upload-photo/>
                        {{--<div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div class="col-span-2">
                                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                                <input type="file" name.defer="image" id="image"
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('image') <span class="text-red-500">{{ $message }}</span>@enderror

                                --}}{{-- If the image is already saved is system show img --}}{{--
                                @if (isset($image) && is_string($image))
                                    <img alt="image" src="{{ '/storage/' . $image }}" class="mt-4" width="200">
                                    --}}{{-- When the image is uploaded show img --}}{{--
                                @elseif (isset($image) && is_object($image))
                                    <img alt="image" src="{{ $image->temporaryUrl() }}" class="mt-4" width="200">
                                @else

                                @endif

                            </div>
                        </div>--}}
                    </x-slot>

                    <x-slot name="footer">
                        <div class="flex gap-3">
                            <x-button.default>
                                Сохранить
                            </x-button.default>
                            <a href="{{route('manage.services')}}">
                                <x-button.secondary x-on:click="showCreateServices = false">
                                    Отмена
                                </x-button.secondary>
                            </a>
                        </div>
                    </x-slot>

                </x-dialog.default>
            </form>
        </div>
    </div>
    <div class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5">
        <livewire:manage.services/>
    </div>
</x-dashboard.shell>
