<div x-data x-init="() => { window.scrollTo(0, 0); }">
    <div class="">
        <div class="">
            @livewire('connect.profile.manage-business-profile', ['business' => $business],
            key(md5("manage-business-profile_{$business->id}")))
        </div>
    </div>
</div>
