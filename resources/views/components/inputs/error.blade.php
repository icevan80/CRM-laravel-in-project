@props(['for'])

@error($for)
<p {{ $attributes->merge(['class' => 'text-sm text-error-color mt-2']) }}>{{ $message }}</p>
@enderror
