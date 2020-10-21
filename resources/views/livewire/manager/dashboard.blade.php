<div>
    @can('own-enterprise')
    <div class="py-4 gap-4 grid grid-cols-1">
        <div class="px-4">
            @livewire('manager.enterprise-list')
        </div>
        <div class="sm:px-4">
            @livewire('enterprise.create-new-enterprise')
        </div>
    </div>
    @endcan

    @cannot('own-enterprise')
    <div>
        @livewire('manager.become-a-manager')
    </div>
    @endcannot
</div>
