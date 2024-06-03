@php
    if ($attributes['active']) {
        $color = $attributes['active-color'];
        $hoverColor = str_replace('-color', '-variant-color', $color);
    } else {
        $color = $attributes['not-active-color'];
          $hoverColor = str_replace('-color', '-variant-color', $color);
  }

@endphp

<button  {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-2 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:'.$hoverColor.' focus:bg-pink-600 active:bg-pink-800 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition ease-in-out duration-150 '.$color ]) }}>
    {{ $slot }}
</button>

