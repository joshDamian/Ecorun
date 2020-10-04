<div>
    @cannot('manage-enterprise')
    <div>
        @livewire('manager.not-a-manager')
    </div>
    @endcannot

    @can('manage-enterprise')
    <div class="grid grid-cols-1">
        <div class="py-4 bg-white px-4">
            @livewire('manager.landing-page.action-switch')
        </div>
        <div class="py-4 bg-cool-gray-200 px-4">
            @livewire('manager.landing-page.action-view')
        </div>
    </div>
    @endcan
</div>
