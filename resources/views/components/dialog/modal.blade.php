@props(['id', 'maxWidth'])

@php
    $dataParamName = 'show';
    $dataBackRoute = 'none';
    $onLeaveMethod = '';
    if ($attributes['back-route'] != null) {
        $dataBackRoute = $attributes['back-route'];
    }
    if ($attributes['listener'] != null) {
        $dataParamName = $attributes['listener'];
    }
    if ($attributes['onLeaveMethod'] != null) {
        $onLeaveMethod = $attributes['onLeaveMethod'];
    }
    $id = $id ?? md5($attributes->wire('model'));
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth ?? '2xl'];

@endphp

<div
    @if($attributes['wire:model'] != null)
    x-data="{ {{$dataParamName}}: @entangle($attributes->wire('model')).defer }"
    @endif
    x-on:close.stop="{{$dataParamName}} = false; {{$onLeaveMethod}}"
    x-on:keydown.escape.window="{{$dataParamName}} = false; {{$onLeaveMethod}}"
    x-show="{{$dataParamName}}"
    id="{{ $id }}"
    class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: none;"

>
    @if($dataBackRoute != 'none')
        <a href="{{$dataBackRoute}}">
            @endif
            <div x-show="{{$dataParamName}}" class="fixed inset-0 transform transition-all"
{{--                 x-on:click="{{$dataParamName}} = false"--}}
{{--                 x-on:click="{{$dataParamName}} = false; $wire.call('sayAboba')"--}}
{{--                 x-on:click="{{$dataParamName}} = false; $wire.set({{$dataParamName}}, false)"--}}
                 x-on:click=" {{$dataParamName}} = false; {{$onLeaveMethod}}"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            @if($dataBackRoute!='none')
        </a>
    @endif

    <div x-show="{{$dataParamName}}"
         class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
         x-trap.inert.noscroll="{{$dataParamName}}"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        {{ $slot }}
    </div>
</div>
