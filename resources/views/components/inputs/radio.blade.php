<div class="flex">
    <input
        type="radio" {!! $attributes->merge(['class' =>
        'rounded-full text-primary-color font-text-small border-primary-color border-paler-90 border-light-80 ring-primary-color shadow-sm'
        ]) !!} {{$attributes['checkIt'] == "true" ? 'checked' : ''}}>
    <div class="px-1">
        <x-inputs.shell label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}"></x-inputs.shell>
    </div>
</div>
