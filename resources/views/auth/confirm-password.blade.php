<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 font-text-small text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-inputs.default label="{{ __('Password') }}" id="password" class="w-full" type="password" name="password" required autocomplete="current-password" autofocus></x-inputs.default>
            </div>

            <div class="flex justify-end mt-4">
                <x-button.default class="ml-4">
                    {{ __('Confirm') }}
                </x-button.default>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
