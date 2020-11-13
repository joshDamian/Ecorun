<div x-data x-init="() => { window.scrollTo(0, 0); }">
    <div class="">
        <div>
            @livewire('enterprise.edit-enterprise', ['enterprise' => $enterprise])
        </div>
        <div class="mt-6">
            @livewire('profile.manage-enterprise-profile', ['enterprise' => $enterprise])
        </div>
        <div class="mt-4">
            @if($enterprise->isStore())
            @livewire('store.update-store', ['store' => $enterprise->enterpriseable])
            @else
            @livewire('service.update-service', ['service' => $enterprise->enterpriseable])
            @endif
        </div>
    </div>
</div>
