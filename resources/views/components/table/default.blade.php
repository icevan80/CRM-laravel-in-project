@php
    $tbodyBaseClass = 'border-t border-primary-color border-paler-90 border-light-80';
    if ($tbody->attributes['border-none']) {
        $tbodyBaseClass = '';
    }

@endphp

<table class="w-full border-collapse background-color text-left font-text-small text-on-surface-color min-w-screen">
    @if(isset($thead))
        <thead {{ $thead->attributes->merge(['class' => 'primary-variant-color bg-paler-90 bg-light-90' ]) }}>
        {{ $thead }}
        </thead>
    @endif
    <tbody {{ $tbody->attributes->merge(['class' => $tbodyBaseClass ]) }}>
    {{ $tbody }}
    </tbody>
</table>
