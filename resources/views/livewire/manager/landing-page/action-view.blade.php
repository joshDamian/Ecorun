<div>
    @switch($activeView)
    @case("create new enterprise")
    <div>
        @livewire('enterprise.create-enterprise')
    </div>
    @break
    @case("manage enterprises")
    <div>
        @livewire('manager.manage-enterprises')
    </div>
    @break
    @default
    <div class="flex py-4 px-4 justify-center">
        <div>
            <i style="font-size: 10rem;" class="text-blue-700 fa fa-battery-empty"></i>
            <div class="text-center mt-4 text-lg font-bold text-blue-700">
                no view for your request yet
            </div>
        </div>
    </div>
    @endswitch
</div>
