<div class="h-full overflow-y-auto">
    <div @click=" active_item = null " class="p-3 text-right md:hidden">
        <i class="text-lg text-blue-800 fas fa-times"></i>
    </div>

    <div x-show="active_item === 'categories'" class="font-light text-black nav-content">
        {{-- <div class=px-4 tracking-wider"text-left font-medium text-lg rounded-lg p-2 shadow border border-gray-400">
            Shop By Categories
        </div>

        <div class="px-4 py-3 tracking-wider text-left border-b border-gray-300 hover:border-black md:cursor-pointer">
            Mobile Phones
        </div>

        <div class="px-4 py-3 tracking-wider text-left border-b border-gray-300 hover:border-black md:cursor-pointer">
            Shirts
        </div>

        <div class="px-4 py-3 tracking-wider text-left border-b border-gray-300 hover:border-black md:cursor-pointer">
            Trousers
        </div>
        --}}
    </div>

    <div x-show="active_item === 'user'" class="font-light nav-content">
        <div class="flex flex-wrap items-center px-4 py-3 bg-white border-b border-gray-200 shadow md:rounded-t-lg">
            @if($user->currentProfile->profile_photo_url ?? false)
            <div style="background-image: url('{{ $user->currentProfile->profile_photo_url }}'); background-size: cover; background-position: center center;" class="w-16 h-16 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
            </div>

            @else
            <div>
                <span class="fa-stack fa-2x">
                    <i class="text-blue-800 fas fa-circle fa-stack-2x"></i>
                    <i class="fa-stack-1x fas text-white @auth fa-user-shield @endauth @guest fa-user @endguest"></i>
                </span>
            </div>
            @endif

            <div class="grid grid-cols-1 gap-1">
                <div class="text-left">
                    <div class="text-lg font-semibold text-blue-800">
                        {{ $user->currentProfile->name ?? __('Guest') }}
                    </div>

                    @auth
                    <div class="font-hairline text-gray-600">
                        {{ $user->currentProfile->full_tag() }}
                    </div>
                    @endauth
                </div>

                @auth
                @livewire('connect.profile.following-followers-counter', ['profile' => $user->currentProfile])
                @endauth
            </div>
        </div>

        <a href="{{ route('home') }}">
            <div class="py-3 px-4 tracking-wider border-b-2 text-left @if(request()->routeIs('home')) border-blue-700 @else border-gray-200 @endif hover:border-blue-700 bg-gray-100 font-medium text-lg text-blue-800 md:cursor-pointer">
                <i class="fa fa-home"></i> &nbsp;Home
            </div>
        </a>

        @auth

        <div class="px-4 py-3 my-1 text-lg font-semibold tracking-wider text-left text-blue-700 bg-white">
            {{ $user->currentProfile->full_tag() }} <i class="text-green-400 fas fa-check-circle"></i>
        </div>

        <a href="{{ route('profile.visit', ['tag' => $user->currentProfile->tag]) }}">
            <div class="py-3 px-4 tracking-wider border-b-2 text-left @if(request()->routeIs('profile.visit') && (explode('/', request()->getRequestUri())[1] === $user->currentProfile->full_tag())) border-blue-700 @else border-gray-200 @endif hover:border-blue-700 bg-gray-100 font-medium text-lg text-blue-800 md:cursor-pointer">
                <i class="fa fa-eye"></i> &nbsp;Visit
            </div>
        </a>

        <a href="{{ route('current-profile.edit', ['tag' => $user->currentProfile->tag, 'user' => $user->profile->data_slug('name')]) }}">
            <div class="py-3 px-4 tracking-wider border-b-2 text-left @if(request()->routeIs('current-profile.edit')) border-blue-700 @else border-gray-200 @endif hover:border-blue-700 bg-gray-100 font-medium text-lg text-blue-800 md:cursor-pointer">
                <i class="fa fa-edit"></i> &nbsp;Edit
            </div>
        </a>

        @if($user->currentProfile->isBusiness())
        <a href="{{ route('business.dashboard', ['tag' => $user->currentProfile->tag, 'business' => $user->currentProfile->profileable->id, 'active_action' => 'products']) }}">
            <div class="py-3 px-4 tracking-wider border-b-2 text-left @if(request()->routeIs('business.dashboard') && (explode('/', request()->getRequestUri())[4] === 'products')) border-blue-700 @else border-gray-200 @endif hover:border-blue-700 bg-gray-100 font-medium text-lg text-blue-800 md:cursor-pointer">
                <i class="fa fa-shopping-bag"></i> &nbsp;Products
            </div>
        </a>

        <a href="{{ route('business.dashboard', ['tag' => $user->currentProfile->tag, 'business' => $user->currentProfile->profileable->id, 'active_action' => 'add-product']) }}">
            <div class="py-3 px-4 tracking-wider border-b-2 text-left  @if(request()->routeIs('business.dashboard') && (explode('/', request()->getRequestUri())[4] === 'add-product')) border-blue-700 @else border-gray-200 @endif hover:border-blue-700 bg-gray-100 font-medium text-lg text-blue-800 md:cursor-pointer">
                <i class="fa fa-plus-circle"></i> &nbsp;Add product
            </div>
        </a>

        <a href="{{ route('business.dashboard', ['tag' => $user->currentProfile->tag, 'business' => $user->currentProfile->profileable->id, 'active_action' => 'team']) }}">
            <div class="py-3 px-4 tracking-wider border-b-2 text-left @if(request()->routeIs('business.dashboard') && (explode('/', request()->getRequestUri())[4] === 'team')) border-blue-700 @else border-gray-200 @endif hover:border-blue-700 bg-gray-100 font-medium text-lg text-blue-800 md:cursor-pointer">
                <i class="fas fa-users"></i> &nbsp;Team
            </div>
        </a>

        @if($user->currentProfile->profileable->isService())
        <a href="{{ route('current-profile.edit', ['tag' => $user->currentProfile->tag, 'user' => $user->profile->data_slug('name')]) }}">
            <div class="py-3 px-4 tracking-wider border-b-2 text-left @if(request()->routeIs('current-profile.edit')) border-blue-700 @else border-gray-200 @endif hover:border-blue-700 bg-gray-100 font-medium text-lg text-blue-800 md:cursor-pointer">
                <i class="fas fa-images"></i> &nbsp;Gallery
            </div>
        </a>
        @endif

        @endif
        @endauth

        {{-- <div class="px-4 py-3 my-1 text-lg font-semibold tracking-wider text-left text-blue-700 bg-white">
            {{ $user->profile->name ?? __('Guest') }} <i class="text-green-400 fas fa-check-circle"></i>
    </div>

    <div class="px-4 py-3 text-lg font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 md:cursor-pointer">
        <i class="fa fa-shopping-cart"></i> &nbsp;Cart
    </div> --}}

    @guest
    <a href="/login">
        <div class="px-4 py-3 text-lg font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 md:cursor-pointer">
            <i class="fa fa-sign-in-alt"></i> &nbsp;Login
        </div>
    </a>
    <a href="/register">
        <div class="px-4 py-3 text-lg font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 md:cursor-pointer">
            <i class="fa fa-registered"></i> &nbsp;Signup
        </div>
    </a>
    @endguest

    {{-- @auth
        <a>
            <div class="px-4 py-3 text-lg font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 md:cursor-pointer">
                <i class="fa fa-clipboard-check"></i> &nbsp;Orders
            </div>
        </a>

        <form method="POST" action="{{ route('logout') }}">
    @csrf
    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                this.closest('form').submit();">
        <div class="px-4 py-3 text-lg font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 md:cursor-pointer">
            <i class="fa fa-sign-out-alt"></i> &nbsp;Logout
        </div>
    </a>
    </form>

    <div class="px-4 py-3 text-lg font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 md:rounded-b-lg md:cursor-pointer">
        <span class="font-bold">&#8358;</span> &nbsp;Auction Sales
    </div>

    @endauth --}}
</div>
</div>
