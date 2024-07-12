<div class="font-text-small">
    <h1>{{ __('Choose translate') }}</h1>
    <div id="set_translation" class="flex gap-4">
        @foreach($translations as $translate)
            <x-inputs.radio
                wire:model="temp_lang"
                value="{{ $translate }}"
                label="{{ __($translate) }}"
                font-size="font-text-mini"></x-inputs.radio>
        @endforeach
        <x-button.default wire:click="changeTranslation('{{$this->temp_lang}}')" wire:loading.attr="disabled">
            {{ __('Choose') }}
        </x-button.default>
        <x-button.default wire:click="$set('createNewTranslation', true)"
                          wire:loading.attr="disabled">
            {{ __('Create') }}
        </x-button.default>
    </div>
    <div class="my-2">
        <x-button.default wire:click="saveTranslationConfig">
            <p>{{ __('Save changes') }}</p>
        </x-button.default>
        <x-button.default wire:click="syncTranslationKeys">
            <p>{{ __('Sync keys') }}</p>
        </x-button.default>
    </div>
    <x-table.default>
        <x-slot name="thead">
            <x-table.row>
                <x-table.column scope="col" class="w-2/3">
                    <p>{{ __('Key name') }}</p>
                </x-table.column>
                <x-table.column scope="col" class="w-1/3">
                    <p>{{ __('Translate') }}</p>
                </x-table.column>
            </x-table.row>
        </x-slot>
        <x-slot name="tbody">
            @foreach($parsedTranslation as $translationValue)
                <x-table.row>
                    <x-table.column class="border">
                        <p>{{ $translationValue['key'] }}</p>
                    </x-table.column>
                    <x-table.column class="border">
                        <x-inputs.text
                            wire:model.debounce.500ms="parsedTranslation.{{ $translationValue['key'] }}.value" class="w-full">
                        </x-inputs.text>
                    </x-table.column>
                </x-table.row>
            @endforeach
        </x-slot>
    </x-table.default>

    <x-dialog.default wire:model="notificationChangesComplete">
        <x-slot name="title">
            {{ __('Translation changes') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Change complete successfully') }}

        </x-slot>

        <x-slot name="footer">
            <div class="flex gap-3">
                <x-button.secondary wire:click="$set('notificationChangesComplete', false)"
                                    wire:loading.attr="disabled">
                    {{ __('Ok') }}
                </x-button.secondary>


            </div>

        </x-slot>
    </x-dialog.default>

    <x-dialog.default wire:model="createNewTranslation">
        <x-slot name="title">
            {{ __('Create translation') }}
        </x-slot>

        <x-slot name="content">
            <x-inputs.label for="code" class="block font-text-small font-medium text-gray-700">{{ __('Code') }}
                - {{ __('Example') }}
                en
            </x-inputs.label>
            <x-inputs.text id="code" wire:model.debounce.500ms="code">
            </x-inputs.text>
            <label for="name" class="block font-text-small font-medium text-gray-700">{{ __('Language name') }}
                - {{ __('Example') }} English</label>
            <x-inputs.text id="name" wire:model.debounce.500ms="name"></x-inputs.text>
        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">
                <x-button.default wire:click="createNewTranslation('{{ $code }}', '{{ $name }}')">
                    {{ __('Create') }}
                </x-button.default>
            </div>
            <div class="flex gap-3">
                <x-button.secondary wire:click="$set('createNewTranslation', false)"
                                    wire:loading.attr="disabled">
                    {{ __('Ok') }}
                </x-button.secondary>


            </div>

        </x-slot>
    </x-dialog.default>
</div>

<style>
    #set_translation * {
        margin: auto 0;
    }
</style>
