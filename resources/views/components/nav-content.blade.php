<div>
    <div @click=" active_item = null " class="text-right md:hidden p-3">
        <i class="fas text-lg text-blue-800 fa-times"></i>
    </div>

    <div x-show="active_item === 'categories'" class="font-light text-black nav-content">
        {{-- <div class= px-4 tracking-wider"text-left font-medium text-lg rounded-lg p-2 shadow border border-gray-400">
            Shop By Categories
        </div>

        <div class="py-3 border-b px-4 tracking-wider text-left hover:border-black md:cursor-pointer border-gray-300">
            Mobile Phones
        </div>

        <div class="py-3 border-b px-4 tracking-wider text-left hover:border-black md:cursor-pointer border-gray-300">
            Shirts
        </div>

        <div class="py-3 border-b px-4 tracking-wider text-left hover:border-black md:cursor-pointer border-gray-300">
            Trousers
        </div>
        --}}
    </div>

    <div x-show="active_item === 'user'" class="font-light nav-content">
        <div class="flex border-gray-200 border bg-white flex-wrap items-center md:rounded-t-lg px-2 py-2 shadow">
            @if($user->profile_photo_url ?? false)
            <div style="background-image: url('{{ $user->profile_photo_url }}'); background-size: cover; background-position: center center;" class="w-16 rounded-full mr-3 h-16">
            </div>
            @else
            <div>
                <span class="fa-stack fa-2x">
                    <i class="fas fa-circle text-blue-800 fa-stack-2x"></i>
                    <i class="fa-stack-1x fas text-white @auth fa-user-shield @endauth @guest fa-user @endguest"></i>
                </span>
            </div>
            @endif

            <div class="grid grid-cols-1 gap-1">
                <div class="text-left">
                    <div class="font-semibold text-blue-800 text-lg">
                        {{ $user->name ?? __('Guest') }}
                    </div>

                    <div class="font-hairline text-gray-600">
                        {{ $user->email ?? __('') }}
                    </div>
                </div>
                @auth
                @livewire('profile.follow-counter')
                @endauth
            </div>
        </div>

        @auth
        <a href="{{ route('timeline.show', ['profile' => $user->profile->id, 'slug' => $user->data_slug('name')]) }}">
            <div class="py-3 border px-4 tracking-wider text-left @if(request()->routeIs('timeline.show') && explode('/', request()->getRequestUri())[3] == $user->profile->id)) border-blue-700 @else border-gray-200 @endif bg-gray-100 font-medium text-lg text-blue-800 hover:border-blue-700 md:cursor-pointer">
                <i class="fa fa-clipboard-list"></i> Timeline
            </div>
        </a>
        @endauth

        @auth
        <div class="py-3 border px-4 tracking-wider text-left  bg-gray-100 font-medium text-lg text-blue-800 hover:border-blue-700 md:cursor-pointer border-gray-200">
            <i class="fa fa-clipboard-check"></i> Orders
        </div>
        @endauth

        <div class="py-3 border px-4 tracking-wider text-left  bg-gray-100 font-medium text-lg text-blue-800 hover:border-blue-700 md:cursor-pointer border-gray-200">
            <i class="fa fa-shopping-cart"></i> Cart
        </div>

        @auth
        <a href="/user/profile">
            <div class="py-3 border px-4 tracking-wider text-left @if(request()->routeIs('profile.show')) border-blue-700 @else border-gray-200 @endif bg-gray-100 font-medium text-lg text-blue-800 hover:border-blue-700 md:cursor-pointer">
                <i class="fa fa-user"></i> Profile
            </div>
        </a>
        @endauth

        @guest
        <a href="/login">
            <div class="py-3 border px-4 tracking-wider text-left  bg-gray-100 font-medium text-lg text-blue-800 hover:border-blue-700 md:cursor-pointer border-gray-200">
                <i class="fa fa-sign-in-alt"></i> Login
            </div>
        </a>
        <a href="/register">
            <div class="py-3 border px-4 tracking-wider text-left  bg-gray-100 font-medium text-lg text-blue-800 hover:border-blue-700 md:cursor-pointer border-gray-200">
                <i class="fa fa-registered"></i> Signup
            </div>
        </a>
        @endguest

        @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                this.closest('form').submit();">
                <div class="py-3 border  bg-gray-100 px-4 tracking-wider text-left font-medium text-lg text-blue-800 hover:border-blue-700 md:cursor-pointer border-gray-200">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </div>
            </a>
        </form>

        <div class="py-3 border  bg-gray-100 px-4 tracking-wider text-left font-medium text-lg text-blue-800 hover:border-blue-700 md:rounded-b-lg md:cursor-pointer border-gray-200">
            <span class="font-bold">&#8358;</span> Auction Sales
        </div>

        @endauth
    </div>
</div>
