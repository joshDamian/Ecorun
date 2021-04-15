<x-app-layout>
    @section('title', 'Ecorun | Login')
    @section('description', "login to Ecorun")
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-logo />
            {{-- <x-jet-authentication-card-logo /> --}}
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label value="{{ __('Email') }}" />
                <x-jet-input class="block w-full mt-1" type="email" name="email" :value="old('email')" required
                    autofocus />
            </div>

            <div x-data="{ show_password: false }">
                <div class="mt-4">
                    <x-jet-label value="{{ __('Password') }}" />
                    <input class="block w-full mt-1 rounded-md shadow-sm form-input"
                        :type="(show_password) ? 'text' : 'password'" name="password" required
                        autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <input x-on:change="show_password = ! show_password" type="checkbox" class="form-checkbox">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Show password') }}</span>
                    </label>
                </div>
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif

                <x-jet-button class="ml-4 bg-blue-700">
                    {{ __('Login') }}
                </x-jet-button>
            </div>
        </form>
        <div class="grid grid-cols-1 gap-4 mt-4">
            <div class="flex justify-center text-gray-600">
                _______ OR _______
            </div>

            <a href="/register" class="font-semibold text-center text-blue-700 underline">
                Signup
            </a>
        </div>
    </x-jet-authentication-card>
</x-app-layout>
