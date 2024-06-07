<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-input.default label="{{ __('Current Password') }}" id="current_password" type="password" class="w-full" wire:model.defer="state.current_password" autocomplete="current-password"></x-input.default>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-inputs.default label="{{ __('New Password') }}" id="password" type="password" class="w-full" wire:model.defer="state.password" autocomplete="new-password" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-inputs.default label="{{ __('Confirm Password') }}" id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button.default>
            {{ __('Save') }}
        </x-button.default>
    </x-slot>
</x-form-section>
