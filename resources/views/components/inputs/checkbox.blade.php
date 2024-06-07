<div class="flex">
    <input type="checkbox" {!! $attributes->merge(['class' =>
            'rounded text-primary-color border-primary-color
            border-dimmer-25 border-lighter-85 ring-primary-color shadow-sm'
            ]) !!} {{$attributes['checkIt'] == "true" ? 'checked' : ''}}>
    <div class="px-2">
        <x-inputs.shell label="{{ $attributes['label'] }}" for="{{ $attributes['id'] }}"></x-inputs.shell>
    </div>
</div>

<style>
    .ring-primary-color:focus{
        --tw-ring-opacity: 1;
        --ring-color-s: var(--primary-s);
        --ring-color-l: var(--primary-l);
        --tw-ring-color: hsl(var(--primary-h) var(--ring-color-s) var(--ring-color-l) / var(--tw-ring-opacity));
    }
</style>
