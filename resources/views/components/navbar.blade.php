<nav class="sticky top-0 w-full text-white bg-blue-800 shadow">
    <div class="flex items-baseline overflow-x-auto select-none">
        <div class="text-gray-200 @guest flex-1 @endguest md:w-1/4 text-xl px-2 py-2 font-extrabold">
            <a href="/">
                {{ config('app.name') }}
            </a>
        </div>

        <div class="flex-1">
            <div class="flex md:text-lg @auth justify-between @endauth font-normal">
                <div @click=" active_item = 'user' " :class="(active_item === 'user') ? 'text-blue-500' : ''" class="flex-shrink-0 px-2 py-2 text-xl md:px-4 sm:cursor-pointer hover:text-blue-500">
                    @auth
                    <i class="fas fa-user-shield"></i> <span class="hidden sm:inline">{{ ucwords(Auth::user()->currentProfile->name) }}</span>
                    @endauth

                    @guest
                    <i class="fas fa-user"></i> <span class="">{{ __('Guest') }}</span>
                    @endguest
                </div>

                <div @click=" active_item = 'shop' " :class="(active_item === 'shop') ? 'text-blue-500' : ''" class="flex-shrink-0 px-2 py-2 text-xl md:px-4 sm:cursor-pointer hover:text-blue-500">
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

                <div class="flex-shrink-0 px-2 py-2 text-xl sm:cursor-pointer md:px-4 hover:text-blue-500">
                    <i class="fas fa-bell"></i>
                    <sup class="sm:hidden">
                        <span class="-mt-2 -ml-5 fa-stack fa-1x">
                            <i style="font-size: 23.5px;" class="text-red-600 fas fa-circle fa-stack-1x"></i>
                            <span class="text-xs font-extrabold text-white fa-stack-1x">99+</span>
                        </span>
                    </sup>

                    <span class="hidden sm:inline">Notifications</span>

                    <sup class="hidden sm:inline">
                        <span class="-mt-2 -ml-3 fa-stack fa-1x">
                            <i style="font-size: 23.5px;" class="text-red-600 fas fa-circle fa-stack-1x"></i>
                            <span class="text-xs font-extrabold text-white fa-stack-1x">99+</span>
                        </span>
                    </sup>
                </div>
                @endauth

                {{-- <div @click=" active_item = 'blog' " :class="(active_item === 'blog') ? 'text-blue-500' : ''" class="flex-shrink-0 px-2 py-2 text-xl sm:cursor-pointer md:px-4 hover:text-blue-500">
                    <i class="fas fa-blog"></i> Blog
                </div>
                --}}
            </div>
        </div>
    </div>
</nav>
