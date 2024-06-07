<div>
    <div>
        <x-inputs.text label="{{ __('Name') }}" class="w-full" name="deal_name" id="name"></x-inputs.text>
        @error('deal_name') <span class="text-error-color">{{ $message }}</span>@enderror
    </div>
    <div>
        <x-inputs.textarea label="{{ __('Description') }}" class="w-full" name="deal_description" id="description"></x-inputs.textarea>
        @error('deal_description') <span class="text-error-color">{{ $message }}</span>@enderror
    </div>

    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

        <div>
            <x-inputs.date label="{{ __('Date Start') }}" name="deal_start_date" id="start_date"
                           class="w-full"></x-inputs.date>
            @error('deal_start_date') <span class="text-error-color">{{ $message }}</span>@enderror
        </div>
        <div>
            <x-inputs.date label="{{ __('Date End') }}" name="deal_end_date" id="end_date"
                   class="w-full"></x-inputs.date>
            @error('deal_end_date') <span class="text-error-color">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
        <div>
            <x-inputs.default label="{{ __('Discount Percentage') }}" type="number" name="deal_discount" id="discount"
                   class="w-full"></x-inputs.default>
            @error('deal_discount') <span class="text-error-color">{{ $message }}</span>@enderror
        </div>
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <x-inputs.checkbox label="{{ __('Is Hidden') }}" name="deal_is_hidden" id="is_hidden"
                          class=""></x-inputs.checkbox>
                @error('deal_is_hidden') <span class="text-error-color">{{ $message }}</span>@enderror
            </div>
            <div>
            </div>
        </div>
    </div>
</div>
