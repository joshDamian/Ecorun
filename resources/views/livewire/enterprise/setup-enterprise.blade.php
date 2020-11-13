<div class="pt-4 md:pt-0 pb-4">
    <div class="mb-6">
        @livewire('enterprise.edit-enterprise', ['enterprise' => $enterprise])
    </div>
    <div class="">
        @livewire('profile.manage-enterprise-profile', ['enterprise' => $enterprise], key($enterprise->id))
    </div>
</div>
