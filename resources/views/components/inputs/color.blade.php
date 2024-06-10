@php
    $color = $attributes['color'];
    $selectedColor = $attributes->wire('model');
    $colorName = str_replace('_', ' ', $color);
    $colorName = ucfirst($colorName);
@endphp

<div class="flex space-x-4 my-4">
    <div class="label-container center-h">
        <x-inputs.label for="{{ $color }}">{{ $colorName }}</x-inputs.label>
    </div>
    <x-inputs.default id="{{ $color }}" name="{{ $color }}" wire:model="scheme.{{$color}}"></x-inputs.default>
    @isset($this->scheme[$color])
        <div class="center-h">
            @if(str_starts_with($color, 'text_on_'))
                <div class="rounded example-color mx-6"
                     style="background-color: rgb({{ $this->scheme[str_replace('text_on_', '', $color)] }})">
                    <p class="example-text" style="color: rgb({{ $this->scheme[$color] }})">Hello world!</p>
                </div>
            @elseif(str_starts_with($color, 'on_'))
                <div class="rounded example-color mx-6 p-1"
                     style="background-color: rgb({{ $this->scheme[str_replace('on_', '', $color)] }})">
                    <div class="w-full h-full rounded"
                         style="background-color: rgb({{ $this->scheme[$color] }})">
                    </div>
                </div>
            @else
                <div class="rounded example-color mx-6"
                     style=" background-color: rgb({{ $this->scheme[$color] }})">
                </div>
            @endif
        </div>
    @endif
</div>

<style>
    .example-color {
        min-width: 32px;
        height: 32px;
    }

    .example-text {
        padding: 3px 8px;
    }
    .center-h {
        margin: auto 0;
    }
    .label-container {
        max-width: 200px; min-width: 200px
    }
</style>
