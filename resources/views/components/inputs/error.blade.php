@props(['for'])

@error($for)
<p {{ $attributes->merge(['class' => 'font-text-small text-error-color mt-2']) }}>{{ $message }}</p>
@enderror
