@props(['value'])

<label {{ $attributes->merge(['class' =>
        'block font-medium font-text-small text-on-surface-color text-light-30'
]) }}>
    {{ $value ?? $slot }}
</label>
