<div class="flex">
    <input
        type="radio" {!! $attributes->merge(['class' =>
        'rounded-full text-primary-color border-primary-color
            border-dimmer-25 border-lighter-85 ring-primary-color shadow-sm'
        ]) !!} {{$attributes['checkIt'] == "true" ? 'checked' : ''}}>
    <div class="px-1">
        <x-inputs.shell label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}"></x-inputs.shell>
    </div>
</div>
