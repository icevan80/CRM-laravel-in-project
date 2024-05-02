{{--@props(['service', 'categories'])--}}

<div>
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <x-input type="text" name="service_name" id="name" class="w-full"></x-input>
        @error('service_name') <span class="text-red-500">{{ $message }}</span>@enderror
    </div>
    <div x-data="{inputRange: false}">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700"><span x-show="inputRange">Min </span>Price</label>
                <x-input type="text" name="service_price" id="price" class="w-full"></x-input>
                @error('service_price') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>


            <div x-show="inputRange">
                <label for="max_price" class="block text-sm font-medium text-gray-700">Max Price</label>
                <x-input type="text" name="service_max_price" id="max_price" class="w-full"></x-input>
                @error('service_max_price') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="flex">
            <x-checkbox class="my-2" x-on:click="inputRange = !inputRange"></x-checkbox>
            <p class="my-1 px-2">Input range</p>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
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

        <div>
            <label
                class="block text-sm font-medium text-gray-700">Type</label>

            <div class="flex my-2">
                <input class="m-2" type="radio" id="personal" name="service_type" value="personal" checked/>
                <label class="pr-4 my-1" for="personal">Personal</label>
                <input class="m-2" type="radio" id="group" name="service_type" value="group"/>
                <label class="pr-4 my-1" for="group">Group</label>
            </div>
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Duration</label>
        <div class="flex">


            <div>
                <label  for="duration_hours" class="block text-sm font-medium text-gray-700">Hours</label>
                <select name="service_duration_hours" id="duration_hours"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                    @for ($hours = 0; $hours <= 12; $hours++)
                        <option
                            value="{{ ($hours * 60) }}">
                            {{$hours}}
                        </option>
                    @endfor
                    @error('service_duration_hours') <span class="text-red-500">{{ $message }}</span>@enderror
                </select>
            </div>
            <div class="m-2"></div>
            <div>
                <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Minutes</label>
                <select name="service_duration_minutes" id="duration_minutes"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                    @for ($minutes = 15; $minutes <= 60; $minutes += 15)
                        <option
                            value="{{ $minutes % 60 }}">{{ $minutes % 60 }}
                        </option>
                    @endfor
                    @error('service_duration_minutes') <span class="text-red-500">{{ $message }}</span>@enderror
                </select>
            </div>
        </div>
    </div>
    <div>
        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
        <textarea id="notes" name="service_notes"
                  class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
        @error('service_notes') <span class="text-red-500">{{ $message }}</span>@enderror
    </div>
    <div>
        <label>Masters</label>
        <div x-data="{masterCount: 1}">
            <template x-for="i in masterCount">
                <select name="service_masters[]" id="masters"
                        class="block my-2 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option disabled selected>
                            Выберите мастера
                        </option>
                    @foreach ($masters as $master)
                        <option
                            value="{{$master->user_id}}">{{ $master->user->name}}
                        </option>
                    @endforeach
                    @error('service_masters') <span class="text-red-500">{{ $message }}</span>@enderror
                </select>
            </template>
            <x-button.default type="button" x-on:click="masterCount += 1">Добавить мастера</x-button.default>
        </div>
    </div>
    <div>
        <label for="is_hidden" class="block text-sm font-medium text-gray-700">Is Hidden</label>

        <input type="checkbox" name="service_is_hidden" id="is_hidden">
        @error('service_is_hidden') <span class="text-red-500">{{ $message }}</span>@enderror
    </div>
    <livewire:components.upload-photo :tag="'service_image'"/>
</div>
