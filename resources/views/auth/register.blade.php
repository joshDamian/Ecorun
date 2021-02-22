<x-app-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-logo />
            {{-- <x-jet-authentication-card-logo /> --}}
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- <div>
                <x-jet-label value="{{ __('Name') }}" />
            <x-jet-input class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus
                autocomplete="name" />
            </div> --}}

            <div class="mt-4">
                <x-jet-label value="{{ __('Email') }}" />
                <x-jet-input class="block w-full mt-1" type="email" name="email" :value="old('email')" required />
            </div>

            <div x-data="{ show_password: false }">
                <div class="mt-4">
                    <x-jet-label value="{{ __('Password') }}" />
                    <input class="block w-full mt-1 rounded-md shadow-sm form-input"
                        :type="(show_password) ? 'text' : 'password'" name="password" required
                        autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-jet-label value="{{ __('Confirm Password') }}" />
                    <input class="block w-full mt-1 rounded-md shadow-sm form-input"
                        :type="(show_password) ? 'text' : 'password'" name="password_confirmation" required
                        autocomplete="new-password" />
                </div>

                <div class="flex items-center justify-start mt-4">
                    <input type="checkbox" x-on:change="show_password = ! show_password"> <span> &nbsp; show
                        password</span>
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4 bg-blue-700">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>