<x-guest-layout>
    <x-authentication-card>

        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif


        @if (session('errormsg'))
            <div class="mb-4 font-medium text-sm text-red-600">
                {{ session('errormsg') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-inputs.default label="{{ __('Email') }}" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"></x-inputs.default>
            </div>

            <div class="mt-4">
                <x-inputs.default label="{{ __('Password') }}" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password"></x-inputs.default>
            </div>

            <div class="block mt-4">
                    <x-inputs.checkbox label="{{ __('Remember me') }}" id="remember_me" name="remember"></x-inputs.checkbox>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button.default class="ml-4">
                    {{ __('Log in') }}
                </x-button.default>

            </div>
            <div class="text-center pt-10">
                <span class="text-sm text-gray-600">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-sm text-primary-color hover:bg-darken-35">Create an Account</a>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
