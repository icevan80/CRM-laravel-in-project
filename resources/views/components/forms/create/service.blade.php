{{--@props(['service', 'categories'])--}}

<div>
    <div>
        <x-inputs.text label="{{ __('Name') }}" name="service_name" id="name" class="w-full"></x-inputs.text>
        @error('service_name') <span class="text-error-color">{{ $message }}</span>@enderror
    </div>
    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
        <div>
            <x-inputs.select label="{{__('Category')}}" name="service_category_id" id="category_id">
                <option disabled selected value="">{{__('Select Category')}}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name}}</option>
                @endforeach
            </x-inputs.select>
        </div>

        <div>
            <x-inputs.label>
                {{ __('Type')}}
            </x-inputs.label>

            <div class="flex my-2">
                <x-inputs.radio label="{{__('Personal')}}" id="personal" name="service_type" value="personal"
                                checked></x-inputs.radio>
                <x-inputs.radio label="{{__('Group')}}" id="group" name="service_type" value="group"></x-inputs.radio>
            </div>
        </div>
    </div>
    <div x-data="{inputRange: false}">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <x-inputs.label for="price"><span x-show="inputRange">Min </span>Price</x-inputs.label>
                <x-inputs.default type="text" name="service_price" id="price" class="w-full"></x-inputs.default>
                @error('service_price') <span class="text-error-color">{{ $message }}</span>@enderror
            </div>
            <div x-show="inputRange">
                <x-inputs.default label="{{__('Max Price')}}" type="text" name="service_max_price" id="max_price"
                                  class="w-full"></x-inputs.default>
                @error('service_max_price') <span class="text-error-color">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="my-2">
            <x-inputs.checkbox label="{{ __('Input range') }}"
                               x-on:click="inputRange = !inputRange"></x-inputs.checkbox>
        </div>

    </div>

    <div>
        <x-inputs.label>{{__('Duration')}}</x-inputs.label>
        <div class="flex">
            <div>
                <x-inputs.select label="{{ __('Hours') }}" name="service_duration_hours" id="duration_hours">

                    @for ($hours = 0; $hours <= 12; $hours++)
                        <option
                            value="{{ ($hours * 60) }}">
                            {{$hours}}
                        </option>
                    @endfor
                    @error('service_duration_hours') <span class="text-error-color">{{ $message }}</span>@enderror
                </x-inputs.select>
            </div>
            <div class="m-2"></div>
            <div>
                <x-inputs.select label="{{ __('Minutes') }}" name="service_duration_minutes" id="duration_minutes">

                    @for ($minutes = 15; $minutes <= 60; $minutes += 15)
                        <option
                            value="{{ $minutes % 60 }}">{{ $minutes % 60 }}
                        </option>
                    @endfor
                    @error('service_duration_minutes') <span class="text-error-color">{{ $message }}</span>@enderror
                </x-inputs.select>
            </div>
        </div>
    </div>
    <div>
        <x-inputs.textarea label="{{ __('Notes') }}" id="notes" name="service_notes"
                  class="w-full"></x-inputs.textarea>
        @error('service_notes') <span class="text-error-color">{{ $message }}</span>@enderror
    </div>
    <div>
        <x-inputs.label>Masters</x-inputs.label>
        <div x-data="{masterCount: 1}">
            <template x-for="i in masterCount">
                <select name="service_masters[]" id="master"
                        class="mr-2 my-2 border-primary-color border-dimmer-25 border-lighter-85 ring-primary-color
        rounded-md shadow-sm text-on-surface-color">
                    <option disabled selected>
                        {{ __('Choose Master') }}
                    </option>
                    @foreach ($masters as $master)
                        <option
                            value="{{$master->id}}">{{ $master->user->name}}
                        </option>
                    @endforeach
                </select>
                @error('service_masters') <span class="text-error-color">{{ $message }}</span>@enderror

            </template>
            <x-button.default type="button" x-on:click="masterCount += 1">{{ __('Add Master') }}</x-button.default>
        </div>
    </div>
    <div>
        <x-inputs.checkbox label="{{ __('Is Hidden') }}" name="service_is_hidden" id="is_hidden"></x-inputs.checkbox>
        @error('service_is_hidden') <span class="text-error-color">{{ $message }}</span>@enderror
    </div>
    <livewire:components.upload-photo :tag="'service_image'"/>
</div>
