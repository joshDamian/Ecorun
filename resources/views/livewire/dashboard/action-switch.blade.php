<div>
    <div class="sm:hidden">
        <ul class="flex overflow-x-scroll justify-between scrolling-auto">
            @foreach ($actions as $key => $action)
            <li wire:click="switchAction('{{ $key }}')" class="mr-3 select-none flex-shrink-0">
                <a
                    class="@if($action === $activeAction) {{ $activeClass }} @else {{ $inActiveClass }} @endif">{{ $action['title'] }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <div x-data="{ menu: true }" class="sm:grid hidden grid-cols-1 gap-4">
        @foreach ($actions as $key => $action)
        <div x-show.transition="menu">
            <div wire:click="switchAction('{{ $key }}')" class="cursor-pointer border-blue-700">
                <span class="fa-stack @if($action === $activeAction) text-red-700 @else text-blue-700 @endif fa-2x">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i title="{{ $action['title'] }}" style="font-size: 20px;"
                        class="text-white fa-stack-1x {{ $action['icon-class'] }}"></i>
                </span>
            </div>
        </div>
        @endforeach
        <div x-on:click="menu = ! menu" class="cursor-pointer border-blue-700">
            <span class="fa-stack text-blue-800 fa-2x">
                <i class="fas fa-circle fa-stack-2x"></i>
                <i :title="menu ? 'hide menu' : 'show menu'" style="font-size: 20px;"
                    class="text-white fa-stack-1x fa fa-bars"></i>
            </span>
        </div>
    </div>
</div>
