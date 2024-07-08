<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-inputs.text label="{{ __('Name') }}" id="name" class="w-full" name="name" :value="old('name')" required autofocus autocomplete="name"></x-inputs.text>
            </div>

            <div class="mt-4">
                <x-inputs.default label="{{ __('Email') }}" id="email" class="w-full" type="email" name="email" :value="old('email')" required autocomplete="username"></x-inputs.default>
            </div>

            <div class="mt-4">
                <x-inputs.label for="phone_number" value="{{ __('Phone Number') }}"></x-inputs.label>
                <span class="text-xs">eg: 0112121211</span>
                <x-inputs.default id="phone_number" class="w-full" type="text" name="phone_number" :value="old('phone_number')" required autocomplete="phone_number"></x-inputs.default>
            </div>

            <div class="mt-4">
                <x-inputs.default label="{{ __('Password') }}" id="password" class="w-full" type="password" name="password" required autocomplete="new-password"></x-inputs.default>
            </div>

            <div class="mt-4">
                <x-inputs.default label="{{ __('Confirm Password') }}" id="password_confirmation" class="w-full" type="password" name="password_confirmation" required autocomplete="new-password"></x-inputs.default>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-inputs.label for="terms">
                        <div class="flex items-center">
                            <x-inputs.checkbox name="terms" id="terms" required />
                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline font-text-small text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline font-text-small text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-inputs.label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline font-text-small text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button.default class="ml-4">
                    {{ __('Register') }}
                </x-button.default>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
