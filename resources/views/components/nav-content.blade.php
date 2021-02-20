<div>
    <div class="sticky top-0 p-2 text-left text-white bg-blue-800 md:hidden">
        <div class="flex items-center justify-between">
            <i @click=" open_menu = false"
                class="mr-3 text-2xl cursor-pointer active:text-blue-500 hover:text-blue-500 fas fa-times"></i>
            <div class="flex-1 text-lg font-bold text-center">
                Menu
            </div>
        </div>
    </div>

    <div class="font-light">
        <div class="flex flex-wrap items-center px-4 py-3 bg-white border-b border-gray-200 shadow md:rounded-t-lg">
            @auth
            <div style="background-image: url('{{ $currentProfile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                class="mr-3 border-t-2 border-b-2 border-blue-700 rounded-full w-14 h-14">
            </div>
            @endauth

            @guest
            <div>
                <span class="fa-stack fa-2x">
                    <i class="text-blue-700 far fa-circle fa-stack-2x"></i>
                    <i class="text-blue-700 fa-stack-1x far fa-user"></i>
                </span>
            </div>
            @endguest

            <div class="grid flex-1 grid-cols-1 gap-1">
                <div class="text-left">
                    <div class="font-semibold text-blue-800 text-md">
                        {{ $currentProfile->name }}
                    </div>
                    @auth
                    <div class="font-hairline text-gray-600 truncate">
                        {{ $currentProfile->full_tag() }}
                    </div>
                    @endauth
                </div>
                @auth
                @livewire('connect.profile.following-followers-counter', ['profile' =>
                $currentProfile->loadMissing('following', 'followers')],
                key(md5("displays_following_and_followers_count_for_{$currentProfile->id}")))
                @endauth
            </div>
        </div>

        @auth
        <div class="px-4 py-3 my-1 font-semibold tracking-wider text-left text-blue-700 bg-white text-md">
            {{ $currentProfile->full_tag() }} <i class="text-green-400 fas fa-check-circle"></i>
        </div>

        <a href="{{ $currentProfile->url->visit }}">
            <div
                class="py-3 px-4 tracking-wider border-b-2 text-left @if(request()->routeIs('profile.visit') && (explode('/', request()->getRequestUri())[1] === $currentProfile->full_tag())) border-blue-700 @else border-gray-200 @endif hover:border-blue-700 bg-gray-100 font-medium text-md text-blue-800 md:cursor-pointer">
                <i class="fa fa-eye"></i> &nbsp;Visit
            </div>
        </a>

        <a href="{{ $currentProfile->url->edit }}">
            @if($currentProfileIsBiz)
            <div
                class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 text-md md:cursor-pointer">
                <i class="far fa-edit"></i> &nbsp;Edit
            </div>
            @else
            <div
                class="px-4 py-3 font-medium tracking-wider text-blue-800 bg-gray-100 border-b-2 @if(request()->routeIs('profile.edit') && (explode('/', request()->getRequestUri())[1] === $currentProfile->full_tag())) border-blue-700 @else border-gray-200 @endif textext-left hover:border-blue-700 text-md md:cursor-pointer">
                <i class="far fa-edit"></i> &nbsp;Edit
            </div>
            @endif
        </a>

        <a href="{{ $currentProfile->url->bookmarks }}">
            <div
                class="px-4 py-3 font-medium tracking-wider text-blue-800 bg-gray-100 border-b-2 @if(request()->routeIs('profile.edit') && (explode('/', request()->getRequestUri())[1] === $currentProfile->full_tag())) border-blue-700 @else border-gray-200 @endif textext-left hover:border-blue-700 text-md md:cursor-pointer">
                <i class="text-blue-700 fas fa-star"></i> &nbsp;Bookmarks
            </div>
        </a>

        @if($currentProfileIsBiz)
        <a href="{{ $currentProfile->url->products }}">
            <div
                class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 text-md md:cursor-pointer">
                <i class="fa fa-shopping-bag"></i> &nbsp;Products
            </div>
        </a>

        <a href="{{ $currentProfile->url->add_product }}">
            <div
                class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 text-md md:cursor-pointer">
                <i class="fa fa-plus-circle"></i> &nbsp;Add product
            </div>
        </a>

        <a href="{{ $currentProfile->url->team }}">
            <div
                class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 text-md md:cursor-pointer">
                <i class="fas fa-users"></i> &nbsp;Team
            </div>
        </a>

        <a href="{{ $currentProfile->url->orders }}">
            <div
                class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 text-md md:cursor-pointer">
                <i class="fas fa-clipboard-check"></i> &nbsp;Orders
            </div>
        </a>

        @endif
        @endauth

        <div class="px-4 py-3 my-1 font-semibold tracking-wider text-left text-blue-700 bg-white text-md">
            <i class="far fa-user"></i> &nbsp;{{ $personalProfile->name ?? __('Guest') }}
        </div>


        <a href="{{ route('cart.index') }}">
            <div
                class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:cursor-pointer">
                <i class="fas fa-shopping-cart"></i> &nbsp;Cart <span
                    class="font-extrabold text-red-500">@livewire('buy.cart.cart-items-counter', key("cart_counter_1" .
                    microtime()))</span>
            </div>
        </a>


        @guest
        <a href="/login">
            <div
                class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:cursor-pointer">
                <i class="fa fa-sign-in-alt"></i> &nbsp;Login
            </div>
        </a>
        <a href="/register">
            <div
                class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:cursor-pointer">
                <i class="fa fa-registered"></i> &nbsp;Signup
            </div>
        </a>
        @endguest

        @auth
        <a href="{{ route('manager.dashboard') }}">
            <div
                class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:cursor-pointer">
                <i class="fas fa-store"></i> &nbsp;Businesses
            </div>
        </a>

        <a>
            <div
                class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:cursor-pointer">
                <i class="fa fa-clipboard-check"></i> &nbsp;Orders
            </div>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                this.closest('form').submit();">
                <div
                    class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:cursor-pointer">
                    <i class="fa fa-sign-out-alt"></i> &nbsp;Logout
                </div>
            </a>
        </form>

        @if($hasMultipleProfiles)
        <div class="px-4 py-3 my-1 font-semibold tracking-wider text-left text-blue-700 bg-white border-b text-md">
            Switch profiles <i class="text-green-400 fas fa-retweet"></i>
        </div>

        <div class="grid grid-cols-1 gap-2 px-4">
            <x-connect.profile.switchable-profile :active="$currentProfile->is($personalProfile)"
                :profile="$personalProfile" />
            @foreach($other_profiles as $profile)
            <x-connect.profile.switchable-profile :profile="$profile" :active="$currentProfile->is($profile)" />
            @endforeach
        </div>
        @endif
        @endauth
    </div>
</div>
