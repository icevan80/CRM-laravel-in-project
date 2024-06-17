<div>
    <x-inputs.text label="{{ __('Name') }}" id="client_name" name="client_name"
                   wire:model.debounce.500ms="client.name" class="w-full"></x-inputs.text>
    <div class="w-full relative">
        <x-inputs.text autocomplete="off" label="{{ __('Phone') }}" id="client_phone" name="client_phone" wire:focusout="endSearch"
                       wire:focusin="startSearch"
                       wire:model.debounce.500ms="client.phone" class="w-full"></x-inputs.text>
        @if($this->searchProcess)
            <div class="search-result-list">
                @foreach($clients as $client)
                    <div class="search-result-item">
                        <h1 wire:click="selectClient({{$client}})">
                            {{ $client->phone_number }} - {{ $client->name }}
                        </h1>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <x-inputs.text label="{{ __('Email') }}" id="client_email" name="client_email"
                   wire:model.debounce.500ms="client.email" class="w-full"></x-inputs.text>
    <x-inputs.textarea label="{{ __('Notes') }}" id="client_notes" name="client_notes"
                       wire:model.debounce.500ms="client.notes" class="w-full"></x-inputs.textarea>
</div>

<style>
    .search-result-list {
        position: absolute;
        width: calc(100% + 2px);
        max-height: 300px;
        overflow-y: scroll;
        overflow-x: hidden;
        background-color: white;
        left: -1px;
        top: 60px;
    }

    .search-result-item {
        cursor: pointer;
        padding: 6px 12px;
    }

    .search-result-item:hover {
        background-color: darkgray;

    }
</style>
