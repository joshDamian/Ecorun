<div>
    @if($profile->isUser())
    <div>
        @livewire('connect.profile.manage-user-profile')
    </div>
    @else
    <div>
        @livewire('connect.profile.manage-business-profile', ['business' => $profile->profileable])
    </div>
    @endif
</div>
