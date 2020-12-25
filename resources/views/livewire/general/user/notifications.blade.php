<div>
    <div class="md:hidden">
        <div wire:loading class="w-full">
            <x-loader />
        </div>
    </div>

    <div class="flex flex-wrap p-2 md:p-0 md:pt-2">
        @foreach($profiles as $key => $profile)
        <div class="mb-2 mr-2">
            <x-connect.profile.switch-profile-for-notif :profile="$profile" :active="$profile->is($activeProfile)" />
        </div>
        @endforeach
    </div>

    @if($activeProfile)
    <div class="bg-gray-100">
        <x-connect.profile.profile-notifications :profile="$activeProfile" />
    </div>
    @endif
</div>
