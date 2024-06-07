@props(['value'])

<label {{ $attributes->merge(['class' =>
        'block font-medium text-sm text-on-surface-color text-darken-35'
]) }}>
    {{ $value ?? $slot }}
</label>
