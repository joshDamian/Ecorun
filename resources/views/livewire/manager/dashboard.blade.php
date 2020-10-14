<div>
    @can('own-enterprise')
    <div class="py-4 gap-4 px-4 grid grid-cols-1">
        <div>
            @livewire('manager.enterprise-list')
        </div>
        <div>
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