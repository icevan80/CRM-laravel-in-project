@php
    $color = $attributes['color'];
    $selectedColor = $attributes->wire('model');
    $colorName = str_replace('_', ' ', $color);
    $colorName = ucfirst($colorName);
@endphp

<div class="flex space-x-4 my-4">
    <div style="margin: auto 0; max-width: 200px; min-width: 200px">
        <x-label for="{{ $color }}">{{ $colorName }}</x-label>
    </div>
    <x-input id="{{ $color }}" name="{{ $color }}" wire:model="scheme.{{$color}}"></x-input>
    @isset($this->scheme[$color])
        <div style="margin: auto 0">
                @if(str_starts_with($color, 'text_on_'))
                    <div class="rounded mx-6"
                         style="min-width: 32px; height: 32px; background-color: rgb({{ $this->scheme[str_replace('text_on_', '', $color)] }})">
                        <p style="padding: 3px 8px; color: rgb({{ $this->scheme[$color] }})">Hello world!</p>
                    </div>
                @elseif(str_starts_with($color, 'on_'))
                    <div class="rounded mx-6 p-1"
                         style="min-width: 32px; height: 32px; background-color: rgb({{ $this->scheme[str_replace('on_', '', $color)] }})">
                        <div class="w-full h-full rounded"
                             style="background-color: rgb({{ $this->scheme[$color] }})">
                        </div>
                    </div>
                @else
                    <div class="rounded mx-6"
                         style="min-width: 32px; height: 32px; background-color: rgb({{ $this->scheme[$color] }})">
                    </div>
                @endif
        </div>
    @endif
</div>
