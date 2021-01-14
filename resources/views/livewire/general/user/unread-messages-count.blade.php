<div x-data="{ unread: null }"
    x-init="() => { @if($count > 0) unread = true; @endif Livewire.on('newNotification', () => { unread = true; }) }">
    <a href="{{ route('chat.index') }}"
        class="flex-shrink-0 px-2 py-2 text-xl sm:cursor-pointer md:px-4 hover:text-blue-500">
        <i class="fas fa-comments"></i>
        <sup x-show="unread" class=" sm:hidden">
            <span class="-mt-2 -ml-5 fa-stack fa-1x">
                <i style="font-size: 23.5px;" class="text-red-600 fas fa-circle fa-stack-1x"></i>
                <span x-ref="count_"
                    class="text-xs font-extrabold text-white fa-stack-1x">{{ ($count > 99) ? '99+' : $count }}</span>
            </span>
        </sup>

        <span class="hidden sm:inline">Chat</span>

        <sup x-show="unread" class="hidden sm:inline">
            <span class="-mt-2 -ml-3 fa-stack fa-1x">
                <i style="font-size: 23.5px;" class="text-red-600 fas fa-circle fa-stack-1x"></i>
                <span x-ref="count"
                    class="text-xs font-extrabold text-white fa-stack-1x">{{ ($count > 99) ? '99+' : $count }}</span>
            </span>
        </sup>
    </a>
</div>
