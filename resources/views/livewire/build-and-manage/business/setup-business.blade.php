<div class="pt-4 pb-4 md:pt-0">
    <div class="mb-6">
        @livewire('build-and-manage.business.edit-business', ['business' => $business])
    </div>
    <div class="">
        @livewire('profile.manage-enterprise-profile', ['business' => $business], key($business->id))
    </div>
</div>
