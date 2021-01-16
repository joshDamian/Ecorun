<div>
    <a href="{{ route('chat.index') }}"
        class="flex-shrink-0 px-2 py-2 text-xl sm:cursor-pointer md:px-4 hover:text-blue-500">
        <i class="fas fa-comments"></i>
        @if($count > 0)
        <sup class=" sm:hidden">
            <span class="-mt-2 -ml-5 fa-stack fa-1x">
                <i style="font-size: 23.5px;" class="text-red-600 fas fa-circle fa-stack-1x"></i>
                <span
                    class="text-xs font-extrabold text-white fa-stack-1x">{{ ($count > 99) ? '99+' : $count }}</span>
            </span>
        </sup>
        @endif

        <span class="hidden sm:inline">Chat</span>

        @if($count > 0)
        <sup class="hidden sm:inline">
            <span class="-mt-2 -ml-3 fa-stack fa-1x">
                <i style="font-size: 23.5px;" class="text-red-600 fas fa-circle fa-stack-1x"></i>
                <span
                    class="text-xs font-extrabold text-white fa-stack-1x">{{ ($count > 99) ? '99+' : $count }}</span>
            </span>
        </sup>
        @endif
    </a>
</div>