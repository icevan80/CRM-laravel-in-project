<div>
    <h1>{{ __('Choose translate') }}</h1>
    <div id="set_translation" style="display: flex">
        @foreach($translations as $translate)
            <label>
                <input type="radio" wire:model="temp_lang" value="{{ $translate }}"/>
                {{ __($translate) }}
            </label>
        @endforeach
        <x-button wire:click="changeTranslation('{{$this->temp_lang}}')" wire:loading.attr="disabled">
            <p>{{ __('Choose') }}</p>
        </x-button>
        <x-button wire:click="$set('createNewTranslation', true)"
                  wire:loading.attr="disabled">
            {{ __('Create') }}
        </x-button>
    </div>
    <x-button wire:click="saveTranslationConfig">
        <p>{{ __('Save changes') }}</p>
    </x-button>
    <x-button wire:click="syncTranslationKeys">
        <p>{{ __('Sync keys') }}</p>
    </x-button>
        <table class="overflow-auto rounded-lg border border-gray-200 shadow-md m-5 p-4">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="w-auto py-4 text-left font-medium text-gray-900 border p-2">
                    <p>{{ __('Key name') }}</p>
                </th>
                <th scope="col" class="w-auto py-4 text-left font-medium text-gray-900 border p-2">
                    <p>{{ __('Translate') }}</p>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($parsedTranslation as $translationValue)
                <tr>
                    <td class="font-medium border p-2 w-full">
                        <p>{{ $translationValue['key'] }}</p>
                    </td>
                    <td class="font-medium border p-2 w-full">
                        <x-input type="text"
                                 wire:model.debounce.500ms="parsedTranslation.{{ $translationValue['key'] }}.value">

                        </x-input>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    <x-dialog-modal wire:model="notificationChangesComplete">
        <x-slot name="title">
            {{ __('Translation changes') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Change complete successfully') }}

        </x-slot>

        <x-slot name="footer">
            <div class="flex gap-3">
                <x-secondary-button wire:click="$set('notificationChangesComplete', false)"
                                    wire:loading.attr="disabled">
                    {{ __('Ok') }}
                </x-secondary-button>


            </div>

        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="createNewTranslation">
        <x-slot name="title">
            {{ __('Create translation') }}
        </x-slot>

        <x-slot name="content">
            <label for="code" class="block text-sm font-medium text-gray-700">{{ __('Code') }} - {{ __('Example') }}
                en</label>
            <x-input id="code" type="text" wire:model.debounce.500ms="code"
                     class="border text-gray-900  border-gray-300 rounded-lg">
            </x-input>
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Language name') }}
                - {{ __('Example') }} English</label>
            <x-input id="name" type="text" wire:model.debounce.500ms="name"
                     class="border text-gray-900  border-gray-300 rounded-lg">
            </x-input>
        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">
                <x-button wire:click="createNewTranslation('{{ $code }}', '{{ $name }}')">
                    {{ __('Create') }}
                </x-button>
            </div>
            <div class="flex gap-3">
                <x-secondary-button wire:click="$set('createNewTranslation', false)"
                                    wire:loading.attr="disabled">
                    {{ __('Ok') }}
                </x-secondary-button>


            </div>

        </x-slot>
    </x-dialog-modal>
</div>

<style>
    #set_translation * {
        padding: 4px 6px;
        margin: 0 8px;
    }
</style>
