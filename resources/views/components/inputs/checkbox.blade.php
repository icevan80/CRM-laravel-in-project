<div class="flex">
    <input
        type="checkbox" {!! $attributes->merge(['class' => 'rounded border-gray-300 text-primary-color focus:border-primary-color focus:ring-primary-color shadow-sm']) !!} {{$attributes['checkIt'] == "true" ? 'checked' : ''}}>
    <x-inputs.shell class="px-2" label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}"></x-inputs.shell>
</div>
