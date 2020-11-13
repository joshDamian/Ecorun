<x-app-layout>
    <div>
        <div class="max-w-7xl mx-auto pt-4 md:pt-0 pb-4">
            @livewire('profile.update-profile-information-form')

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <x-jet-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire('profile.update-password-form')
            </div>
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <x-jet-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire('profile.two-factor-authentication-form')
            </div>
            @endif

            <x-jet-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire('profile.manage-user-profile')
            </div>

            <x-jet-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            <x-jet-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire('profile.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
