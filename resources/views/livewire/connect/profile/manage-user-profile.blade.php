<div>
    <div class="pt-4 pb-4 mx-auto max-w-7xl md:pt-0">
        <div class="grid grid-cols-1 sm:gap-4 sm:grid-cols-6">
            <div class="mx-4 mb-4 sm:col-span-2 sm:mb-0 sm:mx-0">
                <h3 class="text-lg font-medium text-gray-900">
                    Profile Information
                </h3>
                <p class="text-gray-600">
                    Update your name, profile-photo, tag and description.
                </p>
            </div>
            <div class="sm:col-span-4">
                @if($user->profile)
                <div>
                    @livewire('connect.profile.edit-profile', ['profileId' => $user->profile->id],
                    key(md5("edit_profile_for_{$user->profile->id}")))
                </div>

                @else
                <div>
                    @livewire('connect.profile.create-new-profile', ['profileable' => $user])
                </div>
                @endif
            </div>
        </div>

        <x-jet-section-border />
        <div class="grid grid-cols-1 mt-6 sm:mt-0 sm:gap-4 sm:grid-cols-6">
            <div class="mx-4 mb-4 sm:col-span-2 sm:mb-0 sm:mx-0">
                <h3 class="text-lg font-medium text-gray-900">
                    Badges
                </h3>
                <p class="text-gray-600">
                    Create, Add Badges (Badges boost identity recognition).
                </p>
            </div>
            <div class="bg-white shadow md:rounded-lg sm:col-span-4">
                @livewire('connect.badge.manage-badges', ['badgable' => $user, 'credit' => $user->profile])
            </div>
        </div>
        @if($user->fresh()->contacts->fresh()->count() > 0)
        <x-jet-section-border />
        <div class="mt-6 sm:mt-0">
            @livewire('connect.contact.manage-contacts', ['contacts' => $user->fresh()->contacts()])
        </div>
        @endif

        @can('create', [\App\Models\Information\Basic\Contact::class, $user])
        <x-jet-section-border />
        <div class="mt-6 sm:mt-0">
            @livewire('connect.contact.add-contact', ['contactable' => $user])
        </div>
        @endcan

        <x-jet-section-border />
        <div class="mt-6 sm:mt-0">
            @livewire('profile.update-profile-information-form')
        </div>

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
        <x-jet-section-border />
        <div class="mt-6 sm:mt-0">
            @livewire('profile.update-password-form')
        </div>
        @endif

        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
        <x-jet-section-border />
        <div class="mt-6 sm:mt-0">
            @livewire('profile.two-factor-authentication-form')
        </div>
        @endif

        <x-jet-section-border />
        <div class="mt-6 sm:mt-0">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>

        <x-jet-section-border />
        <div class="mt-6 sm:mt-0">
            @livewire('profile.delete-user-form')
        </div>
    </div>
</div>
