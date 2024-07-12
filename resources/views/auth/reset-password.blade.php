<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-widgets.salon-logo/>
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-inputs.default label="{{ __('Email') }}" id="email" class="w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username"></x-inputs.default>
            </div>

            <div class="mt-4">
                <x-inputs.default label="{{ __('Password') }}" id="password" class="w-full" type="password" name="password" required autocomplete="new-password"></x-inputs.default>
            </div>

            <div class="mt-4">
                <x-inputs.default label="{{ __('Confirm Password') }}" id="password_confirmation" class="w-full" type="password" name="password_confirmation" required autocomplete="new-password"></x-inputs.default>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button.default>
                    {{ __('Reset Password') }}
                </x-button.default>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
