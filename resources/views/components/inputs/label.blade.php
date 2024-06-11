@props(['value'])

<label {{ $attributes->merge(['class' =>
        'block font-medium text-sm text-on-surface-color text-light-30'
]) }}>
    {{ $value ?? $slot }}
</label>
