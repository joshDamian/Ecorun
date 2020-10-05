<div>
    @cannot('manage-enterprise')
    <div>
        @livewire('manager.not-a-manager')
    </div>
    @endcannot

    @can('manage-enterprise')
    <div class="grid grid-cols-1 sm:gap-0 gap-4">
        <div class="sm:py-4 sm:px-4">
            @livewire('manager.landing-page.action-switch')
        </div>
        <div class="sm:py-4 sm:px-4 bg-cool-gray-200">
            @livewire('manager.landing-page.action-view')
        </div>
    </div>
    @endcan
</div>