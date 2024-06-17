<div>
    <div>
        <x-inputs.text label="{{ __('Name') }}" name="service_name" id="name" class="w-full"
                 value="{{$service->name}}"></x-inputs.text>
        @error('service_name') <span class="text-red-500">{{ $message }}</span>@enderror
    </div>
    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
        <div>
            <x-inputs.select  label="{{__('Category')}}" name="service_category_id" id="category_id"
                    class="w-full">
                @foreach ($categories as $category)
                    <option
                        @if($service->category_id == $category->id)
                        selected
                        @endif
                        value="{{ $category->id }}">{{ $category->name}}</option>
                @endforeach
            </x-inputs.select>
        </div>

        <div>
            <x-inputs.label>
                {{ __('Type')}}
            </x-inputs.label>

            <div class="flex my-2">
                <x-inputs.radio label="{{__('Personal')}}" class="m-2" id="personal" name="service_type" value="personal"
                                checkIt="{{$service->type == 'personal' ? 'true' : ''}}"
                                 ></x-inputs.radio>
                <x-inputs.radio label="{{__('Group')}}" class="m-2"  id="group" name="service_type" value="group"
                                checkIt="{{$service->type == 'group' ? 'true' : ''}}"
                        ></x-inputs.radio>
            </div>
        </div>
    </div>
    <div x-data="{inputRange: {{isset($service->max_price) ? 'true' : 'false'}}}">
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <x-inputs.label for="price" ><span x-show="inputRange">Min </span>Price</x-inputs.label>
                <x-inputs.default type="text" name="service_price" id="price" class="w-full"
                         value="{{$service->price}}"></x-inputs.default>
            </div>


            <div x-show="inputRange">
                <x-inputs.default label="{{__('Max Price')}}" type="text" name="service_max_price" id="max_price" class="w-full"
                         value="{{$service->max_price}}"></x-inputs.default>
            </div>
        </div>
        <div class="flex">
            <x-inputs.checkbox label="{{ __('Input range') }}" class="my-2" x-on:click="inputRange = !inputRange"
                        checkIt="{{isset($service->max_price) ? 'true' : ''}}"></x-inputs.checkbox>
        </div>
    </div>

    <div>
        <x-inputs.label>{{__('Duration')}}</x-inputs.label>
        <div class="flex">
            <div>
                <x-inputs.select label="{{ __('Hours') }}" name="service_duration_hours" id="duration_hours">
                @for ($hours = 0; $hours <= 12; $hours++)
                        <option
                            @if($service->duration_minutes / 60 == $hours)
                            selected
                            @endif
                            value="{{ ($hours * 60) }}">
                            {{$hours}}
                        </option>
                    @endfor
                </x-inputs.select>
            </div>
            <div class="m-2"></div>
            <div>
                <x-inputs.select label="{{ __('Minutes') }}" name="service_duration_minutes" id="duration_minutes">
                @for ($minutes = 15; $minutes <= 60; $minutes += 15)
                        <option
                            @if($service->duration_minutes % 60 == $minutes  % 60)
                            selected
                            @endif
                            value="{{ $minutes % 60 }}">{{ $minutes % 60 }}
                        </option>
                    @endfor
                </x-inputs.select>
            </div>
        </div>
    </div>
    <div>
        <x-inputs.textarea label="{{ __('Notes') }}" id="notes" name="service_notes"
                           class="w-full">{{$service->notes}}</x-inputs.textarea>
    </div>
    <div>
        <x-inputs.label>Masters</x-inputs.label>
        <div x-data="{masterCount: 0}">
            @foreach($service->masters as $selectedMaster)
                <select name="service_masters[]" id="master"
                        class="mr-2 my-2 border-primary-color border-paler-90 border-light-80 ring-primary-color
        rounded-md shadow-sm text-on-surface-color">
                    <option>
                        {{ __('Remove Master') }}
                    </option>
                    @foreach ($masters as $master)
                        <option
                            @if($master->id == $selectedMaster->id)
                            selected
                            @endif
                            value="{{$master->id}}">{{ $master->user->name}}
                        </option>
                    @endforeach
                    @error('service_masters') <span class="text-red-500">{{ $message }}</span>@enderror
                </select>
            @endforeach
            <template x-for="i in masterCount">
                <select name="service_masters[]" id="master"
                        class="mr-2 my-2 border-primary-color border-paler-90 border-light-80 ring-primary-color
        rounded-md shadow-sm text-on-surface-color">
                    <option disabled selected>
                        {{ __('Choose Master') }}

                    </option>
                    @foreach ($masters as $master)
                        <option

                            value="{{$master->id}}">{{ $master->user->name}}
                        </option>
                    @endforeach
                    @error('service_masters') <span class="text-red-500">{{ $message }}</span>@enderror
                </select>
            </template>
            <x-button.default type="button" x-on:click="masterCount += 1">{{ __('Add Master') }}</x-button.default>
        </div>
    </div>
    <div>

        <x-inputs.checkbox label="{{ __('Is Hidden') }}" name="service_is_hidden" id="is_hidden"></x-inputs.checkbox>

    </div>
    <livewire:components.upload-photo :tag="'service_image'" :source="$service->image"/>
</div>
