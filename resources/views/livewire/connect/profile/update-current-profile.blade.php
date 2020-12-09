<div>
    @if($currentProfile->isUser())
    <div>
        @livewire('connect.profile.manage-user-profile')
    </div>
    @else
    <div>
        @livewire('connect.profile.manage-business-profile', ['business' => $currentProfile->profileable])
    </div>
    @endif
</div>