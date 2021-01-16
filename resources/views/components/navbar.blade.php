@props(['user'])
<nav class="sticky top-0 w-full text-white bg-blue-800 shadow">
    <div class="flex items-center overflow-x-auto overflow-y-hidden select-none">
        <div @click=" function nav() {
            if(window.outerWidth < 768) {
            open_notifications = false; open_menu = true;
            } else {
            open_menu = ! open_menu;
            }
            } nav(); "
            class="flex-shrink-0 px-2 py-2 text-xl cursor-pointer hover:text-blue-500 active:text-blue-500 md:px-4">
            <i class="fas fa-bars"></i>
        </div>

        <div class="text-gray-200 @guest flex-1 @endguest w-1/4 text-xl px-2 py-2 font-extrabold">
            <a href="{{ route('home') }}">
                {{ config('app.name') }}
            </a>
        </div>

        <div class="flex flex-1 md:text-lg @auth justify-between @endauth items-center font-medium">
            <a href="{{ route('home') }}">
                <div class="flex-shrink-0 px-2 py-2 text-xl cursor-pointer md:px-4 hover:text-blue-500">
                    <i class="fas fa-house-user"></i> <span class="hidden sm:inline">Home</span>
                </div>
            </a>

            <a class="flex-shrink-0 px-2 py-2 text-xl cursor-pointer md:px-4 hover:text-blue-500"
                href="{{ route('shop.index') }}">
                <i class="text-xl fas fa-shopping-bag"></i> <span class="@auth hidden @endauth sm:inline">Shop</span>
            </a>

            @auth
            @livewire('general.user.unread-messages-count', ['user' => $user])

            <div @click=" function nav() {
                if(window.outerWidth < 768) {
                open_menu = false; open_notifications = true;
                } else {
                open_notifications = ! open_notifications;
                }
                } nav();"
                class="flex-shrink-0 px-2 py-2 text-xl cursor-pointer active:text-blue-500 md:px-4 hover:text-blue-500">
                @livewire('general.user.unread-notifs-display', ['user' => $user])
            </div>
            @endauth
        </div>
    </div>
</nav>