{{--@props(['service', 'categories'])--}}

<div>
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <x-input type="text" name="service_name" id="name" class="w-full"
                 value="{{$service->name}}"></x-input>
        @error('service_name') <span class="text-red-500">{{ $message }}</span>@enderror
    </div>
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea type="text" id="description" name="service_description"
                  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{$service->description}}</textarea>
        @error('service_description') <span class="text-red-500">{{ $message }}</span>@enderror
    </div>

    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            <x-input type="text" name="service_price" id="price" class="w-full"
                     value="{{$service->price}}"></x-input>
            @error('service_price') <span class="text-red-500">{{ $message }}</span>@enderror

        </div>

        <div>
            <label for="category_id"
                   class="block text-sm font-medium text-gray-700">Category</label>

            <select name="service_category_id" id="category_id"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach ($categories as $category)
                    <option
                       @if($service->category_id == $category->id)
                           selected
                       @endif

                        value="{{ $category->id }}">{{ $category->name}}</option>
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
                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{$service->allergens}}</textarea>
            @error('service_allergens') <span class="text-red-500">{{ $message }}</span>@enderror
        </div>

        <div>
            <label for="cautions" class="block text-sm font-medium text-gray-700">Cautions</label>
            <textarea id="cautions" name="service_cautions"
                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{$service->cautions}}</textarea>
            @error('service_cautions') <span class="text-red-500">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
        <div>
            <label for="benefits" class="block text-sm font-medium text-gray-700">Benefits</label>
            <textarea id="benefits" name="service_benefits"
                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{$service->benefits}}</textarea>
            @error('service_benefits') <span class="text-red-500">{{ $message }}</span>@enderror
        </div>

        <div>
            <label for="aftercare_tips" class="block text-sm font-medium text-gray-700">Aftercare
                Tips</label>
            <textarea id="aftercare_tips" name="service_aftercare_tips"
                      class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{$service->aftercare_tips}}</textarea>
            @error('service_aftercare_tips') <span
                class="text-red-500">{{ $message }}</span>@enderror
        </div>

    </div>
    <div>
        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
        <textarea id="notes" name="service_notes"
                  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{$service->notes}}</textarea>
        @error('service_notes') <span class="text-red-500">{{ $message }}</span>@enderror
    </div>
    <div>
        <label for="is_hidden" class="block text-sm font-medium text-gray-700">Is Hidden</label>

        <input type="checkbox" name="service_is_hidden" id="is_hidden">
        @error('service_is_hidden') <span class="text-red-500">{{ $message }}</span>@enderror
    </div>
    <livewire:components.upload-photo :tag="'service_image'" :source="$service->image"/>
</div>
