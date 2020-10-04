<div>
    <ul class="flex overflow-x-scroll sm:justify-between md:overflow-x-hidden">
        @foreach ($actions as $action)
        <li wire:click="switchAction('{{ $action }}')" class="mr-3 select-none flex-shrink-0">
            <a class="
                @if($action === $activeAction) 
                    {{ $activeClass }} 
                @else 
                    {{ $inActiveClass }} 
                @endif">{{ $action }}</a>
        </li>
        @endforeach
    </ul>
</div>
