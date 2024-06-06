@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-on-surface-color text-darken-35']) }}>
    {{ $value ?? $slot }}
</label>
