<div>
    <h1>{{ __('Choose translate') }}</h1>
    <div id="set_translation" style="display: flex">
        <label>
            <input type="radio" wire:model="temp_lang" value="en"/>
            {{ __('English') }}
        </label>
        <label>
            <input type="radio" wire:model="temp_lang" value="ru"/>
            {{ __('Russian') }}
        </label>
        <label>
            <input type="radio" wire:model="temp_lang" value="custom"/>
            {{ __('Custom translate') }}
        </label>
        <x-button wire:click="changeTranslation('{{$this->temp_lang}}')" wire:loading.attr="disabled">
            <p>{{ __('Choose') }}</p>
        </x-button>
    </div>
    <x-button wire:click="saveTranslationConfig">
        <p>{{ __('Save changes') }}</p>
    </x-button>
    <table>
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
        <tbody class="bg-gray-50">
        @foreach($parsedTranslation as $translationValue)
            <tr>
                <td class="font-medium border p-2">
                    <p>{{ $translationValue['key'] }}</p>
                </td>
                <td class="font-medium border p-2">
                    <x-input type="text" wire:model.debounce.500ms="parsedTranslation.{{ $translationValue['key'] }}.value">

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
</div>

<style>
    #set_translation * {
        padding: 8px;
    }
</style>
