<div>
    <div class="md:hidden">
        <div wire:loading class="w-full">
            <x-loader />
        </div>
    </div>

    <div class="flex flex-wrap p-2 md:p-0 md:pt-2">
        <div class="mb-2 mr-2">
            <x-connect.profile.switch-profile-for-notif :profile="$currentProfile" :active="$currentProfile->is($activeProfile)" />
        </div>
        <div class="mb-2 mr-2">
            <x-connect.profile.switch-profile-for-notif :profile="$personal_profile" :active="$personal_profile->is($activeProfile)" />
        </div>
        @foreach($associatedProfiles as $key=> $profile)
        @continue($profile->is($currentProfile) || ($profile->is($personal_profile)))
        <div class="mb-2 mr-2">
            <x-connect.profile.switch-profile-for-notif :profile="$profile" :active="$profile->is($activeProfile)" />
        </div>
        @endforeach
    </div>

    @if($activeProfile)
    <div class="p-2 bg-gray-100">
        <x-connect.profile.profile-notifications :profile="$activeProfile" />
        {{ $activeProfile->tag }}
        {{-- @livewire('connect.profile.profile-notification-handler', ['profile' => $activeProfile]) --}}
    </div>
    @endif
</div>
