<div>
    <div class="grid grid-cols-3">
        <div class="@if ($listShow)
            col-span-3
        @else
            col-span-1
        @endif">
            @livewire('manager.enterprise-list')
        </div>
        @if($enterpriseShow)
        <div class="col-span-2">
            @livewire('enterprise.dashboard')
        </div>
        @endif
    </div>
</div>
