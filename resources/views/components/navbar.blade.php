@props(['user'])
<nav class="sticky top-0 z-40 w-full text-white bg-blue-800 shadow">
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

        <div class="w-1/4 px-2 py-2 text-xl font-extrabold text-gray-200">
            <a href="{{ route('home') }}">
                {{ config('app.name') }}
            </a>
        </div>

        <div class="flex items-center justify-between flex-1 font-medium md:text-lg">
            <a class="flex-shrink-0 px-2 py-2 text-xl cursor-pointer md:px-4 hover:text-blue-500"
                href="{{ route('home') }}">
                <i class="fas fa-house-user"></i> <span class="hidden md:inline">Home</span>
            </a>

            <a class="flex-shrink-0 px-2 py-2 text-xl cursor-pointer md:px-4 hover:text-blue-500"
                href="{{ route('shop.index') }}">
                <i class="text-xl fas fa-shopping-bag"></i> <span class="hidden md:inline">Shop</span>
            </a>

            <a class="flex-shrink-0 px-2 py-2 text-xl cursor-pointer md:px-4 hover:text-blue-500"
                href="{{ route('search.index') }}">
                <i class="fas fa-search"></i> <span class="hidden md:inline">Search</span>
            </a>

            @auth
            <a href="{{ route('chat.index') }}"
                class="flex-shrink-0 px-2 py-2 text-xl sm:cursor-pointer md:px-4 hover:text-blue-500">
                @livewire('general.user.unread-messages-count', ['user' => $user], key(md5('i_count_unread_messages')))
            </a>

            <div x-on:click=" function nav() {
                if(window.outerWidth < 768) {
                open_menu = false; open_notifications = true;
                } else {
                open_notifications = ! open_notifications;
                }
                } nav();"
                class="flex-shrink-0 px-2 py-2 text-xl cursor-pointer active:text-blue-500 md:px-4 hover:text-blue-500">
                @livewire('general.user.unread-notifs-display', ['user' => $user],
                key(md5('i_count_unread_notifications_yes')))
            </div>
            @endauth
        </div>
    </div>
</nav>