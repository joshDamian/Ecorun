<div>
    @if($profile->isUser())
    <div>
        @livewire('connect.profile.manage-user-profile')
    </div>
    @else
    <div>
        @livewire('connect.profile.manage-business-profile', ['profile' => $profile])
    </div>
    @endif
</div>
