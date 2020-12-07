<x-app-layout>
    <div>
        <div class="pt-4 pb-4 mx-auto max-w-7xl md:pt-0">
            <div class="mt-2 sm:mt-0">
                @livewire('connect.profile.manage-user-profile')
            </div>

            <x-jet-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire('profile.update-profile-information-form')
            </div>


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
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            <x-jet-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire('profile.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>