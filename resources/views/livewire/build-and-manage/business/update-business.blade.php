<div x-data x-init="() => { window.scrollTo(0, 0); }">
    <div class="">
        <div>
            @livewire('build-and-manage.business.edit-business', ['business' => $business])
        </div>
        <div class="mt-6">
            @livewire('connect.profile.manage-business-profile', ['business' => $business])
        </div>
    </div>
</div>