<div class="flex">
    <input type="checkbox" {!! $attributes->merge(['class' =>
            'rounded text-primary-color border-primary-color
            border-primary-color border-paler-90 border-light-80 ring-primary-color shadow-sm'
            ]) !!} {{$attributes['checkIt'] == "true" ? 'checked' : ''}}>
    <div class="px-2">
        <x-inputs.shell label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}"></x-inputs.shell>
    </div>
</div>
