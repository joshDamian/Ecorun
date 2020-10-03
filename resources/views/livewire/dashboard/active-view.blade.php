<div>
    @switch($activeView['title'])
    @case("view orders")
    <div>
        @livewire('order.list-orders')
    </div>
    @break
    @case("manager dashboard")
    <div>
        @livewire('manager.dashboard')
    </div>
    @break
    @default
    <div class="flex py-4 px-4 justify-center">
        <div>
            <i style="font-size: 10rem;" class="text-blue-700 {{ $activeView['icon-class'] }}"></i>
            <div class="text-center mt-4 text-lg font-bold text-blue-700">
                no view for your request yet
            </div>
        </div>
    </div>
    @break
    @endswitch
</div>
