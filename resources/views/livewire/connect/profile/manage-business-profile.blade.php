<div>
    <div class="pb-4 sm:py-0">
        <div class="grid grid-cols-1 sm:gap-4 sm:grid-cols-6">
            <div class="mx-4 mb-4 sm:col-span-2 md:mx-0 sm:mb-0">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __('Update ') . $profile->name }}
                </h3>
                <p class="text-gray-600">
                    Edit your business's cover-photo, unique name, tag and description.
                </p>
            </div>
            <div class="sm:col-span-4">
                @if($profile)
                <div>
                    @livewire('connect.profile.edit-profile', ['profileId' => $profile->id],
                    key(md5("edit_profile_{$profile->id}")))
                </div>
                @else
                <div>
                    @livewire('connect.profile.create-new-profile', ['profileable' =>
                    $profile->loadMissing('profileable')->profileable])
                </div>
                @endif
            </div>
        </div>

        <x-jet-section-border />
        <div class="grid grid-cols-1 mt-6 sm:mt-4 sm:grid-cols-6">
            <div class="mx-4 mb-4 sm:col-span-2 sm:mb-0 sm:mx-0">
                <h3 class="text-lg font-medium text-gray-900">
                    Badges
                </h3>
                <p class="text-gray-600">
                    Create, Add Badges (Badges boost identity recognition).
                </p>
            </div>
            <div class="bg-white shadow md:rounded-lg sm:col-span-4">
                @livewire('connect.badge.manage-badges', ['badgable' => $profile->profileable])
            </div>
        </div>
    </div>
</div>
