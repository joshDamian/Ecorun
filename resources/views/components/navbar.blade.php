<nav class="shadow sticky top-0 w-full bg-blue-800 text-white">
    <div class="select-none items-baseline overflow-x-auto flex">
        <div class="text-gray-400 @guest flex-1 @endguest md:w-80 text-xl px-2 py-2 font-extrabold">
            <a href="/">
                Logo
            </a>
        </div>

        <div class="flex-1">
            <div class="flex md:text-lg @auth justify-between @endauth font-normal">
                <div @click=" active_item = 'user' " :class="(active_item === 'user') ? 'text-blue-500' : ''" class="px-2 text-xl md:px-4 sm:cursor-pointer flex-shrink-0 py-2 hover:text-blue-500">
                    @auth
                    <i class="fas fa-user-shield"></i> <span class="hidden sm:inline">{{ ucwords(Auth::user()->name) }}</span>
                    @endauth

                    @guest
                    <i class="fas fa-user"></i> <span class="">{{ __('Guest') }}</span>
                    @endguest
                </div>

                <div @click=" active_item = 'shop' " :class="(active_item === 'shop') ? 'text-blue-500' : ''" class="px-2 text-xl md:px-4 sm:cursor-pointer flex-shrink-0 py-2 hover:text-blue-500">
                    <i class="fas text-xl fa-shopping-bag"></i> <span class="@auth hidden @endauth sm:inline">Shop</span>
                </div>

                @auth
                <div class="px-2 py-2 flex-shrink-0 sm:cursor-pointer md:px-4 text-xl hover:text-blue-500">
                    <i class="fas fa-comments"></i>
                    <sup class="sm:hidden">
                        <span class="fa-stack -ml-5 -mt-2 fa-1x">
                            <i style="font-size: 23.5px;" class="fas fa-circle text-red-600 fa-stack-1x"></i>
                            <span class="fa-stack-1x text-white font-extrabold text-xs">10</span>
                        </span>
                    </sup>

                    <span class="hidden sm:inline">Chat</span>

                    <sup class="hidden sm:inline">
                        <span class="fa-stack -ml-3 -mt-2 fa-1x">
                            <i style="font-size: 23.5px;" class="fas fa-circle text-red-600 fa-stack-1x"></i>
                            <span class="fa-stack-1x text-white font-extrabold text-xs">10</span>
                        </span>
                    </sup>
                </div>

                <div class="px-2 py-2 text-xl flex-shrink-0 sm:cursor-pointer md:px-4  hover:text-blue-500">
                    <i class="fas fa-bell"></i>
                    <sup class="sm:hidden">
                        <span class="fa-stack -ml-5 -mt-2 fa-1x">
                            <i style="font-size: 23.5px;" class="fas fa-circle text-red-600 fa-stack-1x"></i>
                            <span class="fa-stack-1x text-white font-extrabold text-xs">99+</span>
                        </span>
                    </sup>

                    <span class="hidden sm:inline">Notifications</span>

                    <sup class="hidden sm:inline">
                        <span class="fa-stack -ml-3 -mt-2 fa-1x">
                            <i style="font-size: 23.5px;" class="fas fa-circle text-red-600 fa-stack-1x"></i>
                            <span class="fa-stack-1x text-white font-extrabold text-xs">99+</span>
                        </span>
                    </sup>
                </div>
                @endauth

                {{-- <div @click=" active_item = 'blog' " :class="(active_item === 'blog') ? 'text-blue-500' : ''" class="px-2 py-2 flex-shrink-0 text-xl sm:cursor-pointer md:px-4 hover:text-blue-500">
                    <i class="fas fa-blog"></i> Blog
                </div>
                --}}
            </div>
        </div>
    </div>
</nav>