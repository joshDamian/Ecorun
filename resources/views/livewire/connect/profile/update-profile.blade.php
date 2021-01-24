<div>
    @if($profile->isUser())
    <div>
        @livewire('connect.profile.manage-user-profile', key('manage_user_profile'))
    </div>
    @else
    <div>
        @livewire('connect.profile.manage-business-profile', ['profile' => $profile],
        key("manage_business_profile_for_{$profile->id}"))
    </div>
    @endif
</div>
