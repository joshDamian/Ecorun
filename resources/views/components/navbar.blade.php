<nav class="sticky top-0 w-full text-white bg-blue-800 shadow">
    <div class="flex items-center overflow-x-auto select-none">
        <div @click=" function nav() { 
            if(window.outerWidth < 768) {
                open_notifications = false; open_menu = true;
            } else {
                open_menu = ! open_menu;
            }
         } nav(); " class="flex-shrink-0 px-2 py-2 text-xl md:px-4 sm:cursor-pointer">
            <i class="fas fa-bars"></i>
        </div>

        <div class="text-gray-200 @guest flex-1 @endguest w-1/3 text-xl px-2 py-2 font-extrabold">
            <a href="/">
                {{ config('app.name') }}
            </a>
        </div>

        <div class="flex flex-1 md:text-lg @auth justify-between @endauth items-center font-medium">

            <div class="flex-shrink-0 px-2 py-2 text-xl md:px-4 sm:cursor-pointer hover:text-blue-500">
                <i class="text-xl fas fa-shopping-bag"></i> <span class="@auth hidden @endauth sm:inline">Shop</span>
            </div>

            @auth
            <div class="flex-shrink-0 px-2 py-2 text-xl sm:cursor-pointer md:px-4 hover:text-blue-500">
                <i class="fas fa-comments"></i>
                <sup class="sm:hidden">
                    <span class="-mt-2 -ml-5 fa-stack fa-1x">
                        <i style="font-size: 23.5px;" class="text-red-600 fas fa-circle fa-stack-1x"></i>
                        <span class="text-xs font-extrabold text-white fa-stack-1x">10</span>
                    </span>
                </sup>

                <span class="hidden sm:inline">Chat</span>

                <sup class="hidden sm:inline">
                    <span class="-mt-2 -ml-3 fa-stack fa-1x">
                        <i style="font-size: 23.5px;" class="text-red-600 fas fa-circle fa-stack-1x"></i>
                        <span class="text-xs font-extrabold text-white fa-stack-1x">10</span>
                    </span>
                </sup>
            </div>

            <div @click=" function nav() {
                if(window.outerWidth < 768) { 
                    open_menu = false; open_notifications = true; 
                    Livewire.emit('showNotifications');
                } else {
                    open_notifications = ! open_notifications;
                    Livewire.emit('toggleNotifications');
                }
            } nav();" class="flex-shrink-0 px-2 py-2 text-xl sm:cursor-pointer md:px-4 hover:text-blue-500">
                <div x-data="{ unread: null }" x-init="() => { Livewire.on('updatedCount', (count) => { 
                    if(count > 0) {
                        unread = true;
                        if(count > 99) {
                            return $refs.count.innerText = '99+'; 
                        }
                        return $refs.count.innerText = count;
                    }
                }) }">
                    <i class="far fa-bell"></i>
                    <sup x-show="unread" class="sm:hidden">
                        <span class="-mt-2 -ml-5 fa-stack fa-1x">
                            <i style="font-size: 23.5px;" class="text-red-600 fas fa-circle fa-stack-1x"></i>
                            <span x-ref="count" class="text-xs font-extrabold text-white fa-stack-1x"></span>
                        </span>
                    </sup>

                    <span class="hidden sm:inline">Notifications</span>
                    <sup x-show="unread" class="hidden sm:inline">
                        <span class="-mt-2 -ml-3 fa-stack fa-1x">
                            <i style="font-size: 23.5px;" class="text-red-600 fas fa-circle fa-stack-1x"></i>
                            <span x-ref="count" class="text-xs font-extrabold text-white fa-stack-1x"></span>
                        </span>
                    </sup>
                </div>
            </div>
            @endauth
        </div>
    </div>
</nav>
