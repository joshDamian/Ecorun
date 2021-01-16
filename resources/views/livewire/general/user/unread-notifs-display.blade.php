<div>
    <i class="far fa-bell"></i>

    @if($count > 0)
    <sup class="sm:hidden">
        <span class="-mt-2 -ml-5 fa-stack fa-1x">
            <i style="font-size: 23.5px;" class="text-red-600 fas fa-circle fa-stack-1x"></i>
            <span class="text-xs font-extrabold text-white fa-stack-1x">{{ ($count > 99) ? '99+' : $count }}</span>
        </span>
    </sup>
    @endif

    <span class="hidden sm:inline">Notifications</span>

    @if($count > 0)
    <sup class="hidden sm:inline">
        <span class="-mt-2 -ml-3 fa-stack fa-1x">
            <i style="font-size: 23.5px;" class="text-red-600 fas fa-circle fa-stack-1x"></i>
            <span class="text-xs font-extrabold text-white fa-stack-1x">{{ ($count > 99) ? '99+' : $count }}</span>
        </span>
    </sup>
    @endif
</div>