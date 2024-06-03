<div class="flex">
    <input
        type="radio" {!! $attributes->merge(['class' => 'rounded-full border-gray-300 text-primary-color focus:border-primary-color focus:ring-primary-color shadow-sm']) !!}>
    <x-inputs.shell class="px-1" label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}"></x-inputs.shell>
</div>
