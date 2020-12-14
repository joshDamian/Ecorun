<div>
    <div class="text-white sticky top-0 md:hidden p-2 bg-blue-800 text-left">
        <div class="flex items-center justify-between">
            <i @click="open = false" class="fas text-2xl fa-times mr-3"></i>
            <div class="text-center text-lg font-bold flex-1">
                Menu
            </div>
        </div>
    </div>

    <div class="font-light">
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

            <div class="grid flex-1 grid-cols-1 gap-1">
                <div class="text-left">
                    <div class="font-semibold text-blue-800 text-md">
                        {{ $user->currentProfile->name ?? __('Guest') }}
                    </div>

                    @auth
                    <div class="font-hairline truncate text-gray-600">
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
            <div class="py-3 px-4 tracking-wider border-b-2 text-left @if(request()->routeIs('home')) border-blue-700 @else border-gray-200 @endif hover:border-blue-700 bg-gray-100 font-medium text-md text-blue-800 md:cursor-pointer">
                <i class="fa fa-home"></i> &nbsp;Home
            </div>
        </a>

        @auth

        <div class="px-4 py-3 my-1 font-semibold tracking-wider text-left text-blue-700 bg-white text-md">
            {{ $user->currentProfile->full_tag() }} <i class="text-green-400 fas fa-check-circle"></i>
        </div>

        <a href="{{ route('profile.visit', ['profile' => $user->currentProfile->tag]) }}">
            <div class="py-3 px-4 tracking-wider border-b-2 text-left @if(request()->routeIs('profile.visit') && (explode('/', request()->getRequestUri())[1] === $user->currentProfile->full_tag())) border-blue-700 @else border-gray-200 @endif hover:border-blue-700 bg-gray-100 font-medium text-md text-blue-800 md:cursor-pointer">
                <i class="fa fa-eye"></i> &nbsp;Visit
            </div>
        </a>

        <a href="{{ route('profile.edit', ['profile' => $user->currentProfile->tag, 'user' => $user->profile->data_slug('name')]) }}">
            <div class="py-3 px-4 tracking-wider border-b-2 textext-left border-gray-200 hover:border-blue-700 bg-gray-100 font-medium text-md text-blue-800 md:cursor-pointer">
                <i class="fa fa-edit"></i> &nbsp;Edit
            </div>
        </a>

        @if($user->currentProfile->isBusiness())
        <a href="{{ route('business.dashboard', ['tag' => $user->currentProfile->tag, 'business' => $user->currentProfile->profileable->id, 'active_action' => 'products']) }}">
            <div class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 text-md md:cursor-pointer">
                <i class="fa fa-shopping-bag"></i> &nbsp;Products
            </div>
        </a>

        <a href="{{ route('business.dashboard', ['tag' => $user->currentProfile->tag, 'business' => $user->currentProfile->profileable->id, 'active_action' => 'add-product']) }}">
            <div class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 text-md md:cursor-pointer">
                <i class="fa fa-plus-circle"></i> &nbsp;Add product
            </div>
        </a>

        <a href="{{ route('business.dashboard', ['tag' => $user->currentProfile->tag, 'business' => $user->currentProfile->profileable->id, 'active_action' => 'team']) }}">
            <div class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 text-md md:cursor-pointer">
                <i class="fas fa-users"></i> &nbsp;Team
            </div>
        </a>

        @if($user->currentProfile->profileable->isService())
        <a href="{{ route('current-profile.edit', ['tag' => $user->currentProfile->tag, 'user' => $user->profile->data_slug('name')]) }}">
            <div class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 hover:border-blue-700 text-md md:cursor-pointer">
                <i class="fas fa-images"></i> &nbsp;Gallery
            </div>
        </a>
        @endif

        @endif
        @endauth

        <div class="px-4 py-3 my-1 font-semibold tracking-wider text-left text-blue-700 bg-white text-md">
            <i class="fas fa-user"></i> &nbsp;{{ $user->profile->name ?? __('Guest') }}
        </div>

        <div class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:cursor-pointer">
            <i class="fa fa-shopping-cart"></i> &nbsp;Cart
        </div>


        @guest
        <a href="/login">
            <div class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:cursor-pointer">
                <i class="fa fa-sign-in-alt"></i> &nbsp;Login
            </div>
        </a>
        <a href="/register">
            <div class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:cursor-pointer">
                <i class="fa fa-registered"></i> &nbsp;Signup
            </div>
        </a>
        @endguest

        @auth
        <a href="{{ route('dashboard', ['active_action' => 'manager-account']) }}">
            <div class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:cursor-pointer">
                <i class="fa fa-user-tie"></i> &nbsp;Manager account
            </div>
        </a>

        <a>
            <div class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:cursor-pointer">
                <i class="fa fa-clipboard-check"></i> &nbsp;Orders
            </div>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                this.closest('form').submit();">
                <div class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:cursor-pointer">
                    <i class="fa fa-sign-out-alt"></i> &nbsp;Logout
                </div>
            </a>
        </form>

        @if($user->business_profiles())
        <div class="px-4 py-3 my-1 font-semibold tracking-wider text-left text-blue-700 bg-white border-b text-md">
            Switch profiles <i class="text-green-400 fas fa-retweet"></i>
        </div>

        <div class="pl-1">
            <x-connect.profile.switchable-profile :profile="$user->profile" />
            @foreach($user->business_profiles() as $profile)
            <x-connect.profile.switchable-profile :profile="$profile" />
            @endforeach
        </div>
        @endif

        {{-- <div class="px-4 py-3 font-medium tracking-wider text-left text-blue-800 bg-gray-100 border-b-2 border-gray-200 text-md hover:border-blue-700 md:rounded-b-lg md:cursor-pointer">
            <span class="font-bold">&#8358;</span> &nbsp;Auction Sales
        </div>
        --}}

        @endauth
    </div>
</div>