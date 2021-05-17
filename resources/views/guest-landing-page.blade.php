<x-app-layout>
    @php
    if(file_exists(base_path('/storage/framework/maintenance.php'))) {
    $maintainanceMode = true;
    } else {
    $maintainanceMode = false;
    }
    @endphp
    <nav class="sticky top-0 z-50 bg-white border-b-4 border-blue-800">
        <div>
            <ul class="flex items-center px-3 py-2">
                <li class="flex-1 text-2xl font-bold text-blue-800">{{ config('app.name') }}</li>
                <li class="text-right">
                    <div class="flex items-center overflow-x-auto">
                        <a href="{{ route('search.index') }}" class="mr-4 text-blue-700">
                            <i class="text-xl fas fa-search"></i>
                        </a>

                        <a class="mr-4" href="{{ ($maintainanceMode) ? __('#') : __('/login') }}">
                            <x-jet-button class="bg-blue-600">
                                Login
                            </x-jet-button>
                        </a>

                        <a href="{{ ($maintainanceMode) ? __('#') : __('/register') }}">
                            <x-jet-button class="bg-blue-800">
                                Signup
                            </x-jet-button>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <main>
        <div class="bg-gray-200">
            <div class="grid grid-cols-1 sm:p-3 md:p-10 md:grid-cols-2">
                <div class="">
                    <h3 class="px-3 py-2 text-xl font-semibold text-gray-800 sm:text-3xl sm:px-0 sm:pb-3 sm:py-0">
                        Connect with people, shop, build and manage businesses.
                    </h3>

                    <h3 class="px-3 pb-3 text-lg font-medium text-gray-600 sm:px-0 sm:pb-4 sm:py-0">
                        Ecorun naturally blends social interaction with doing business.
                    </h3>
                </div>
                <div class="flex items-center justify-center p-4">
                    <h4 class="text-5xl font-bold text-blue-800 animate-pulse sm:text-5xl md:text-6xl">
                        Ecorun
                    </h4>
                </div>

                @if($maintainanceMode)
                <div class="text-2xl font-extrabold text-center text-blue-700 animate-pulse sm:text-3xl">
                    #Maintainance
                </div>
                @endif
            </div>
        </div>

        @if($maintainanceMode)
        <div class="flex justify-center">
            <img src="/icon/maintainance_mode.gif" class="sm:w-6/12" />
        </div>
        @endif

        <div class="grid grid-cols-1 gap-3 bg-gray-200 sm:grid-cols-2 md:grid-cols-3 sm:p-3 sm:gap-3 md:gap-9 md:p-9">
            <div class="bg-white sm:bg-transparent">
                <div class="flex items-center justify-center p-2">
                    <span class="fa-stack fa-3x">
                        <i class="text-blue-800 far fa-circle fa-stack-2x"></i>
                        <i class="text-blue-800 fa-stack-1x fas fa-user-friends"></i>
                    </span>
                </div>

                <div class="p-3 text-gray-600 border-gray-200 sm:bg-white sm:shadow sm:rounded-lg sm:border">
                    <h3 class="text-xl font-semibold text-blue-800">
                        Connect with people
                    </h3>
                    <div class="px-5 py-2">
                        <ul class="text-blue-800 list-disc">
                            <li>
                                <span class="text-gray-700">
                                    Make new friends.
                                </span>
                            </li>

                            <li>
                                <span class="text-gray-700">
                                    Follow amazing trends.
                                </span>
                            </li>

                            <li>
                                <span class="text-gray-700">
                                    Join interesting conversations.
                                </span>
                            </li>

                            <li>
                                <span class="text-gray-700">
                                    Share photos.
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <a href="{{ ($maintainanceMode) ? __('#') : __('/register') }}">
                            <x-jet-button class="mt-2 bg-blue-800 w-100">
                                <i class="fas fa-plus"></i> &nbsp; join the community
                            </x-jet-button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white sm:bg-transparent">
                <div class="flex justify-center p-2">
                    <span class="fa-stack fa-3x">
                        <i class="text-blue-600 far fa-circle fa-stack-2x"></i>
                        <i class="text-blue-600 fas fa-shopping-cart fa-stack-1x"></i>
                        {{-- <span class="font-semibold text-white fa-stack-1x">&#8358;</span> --}}
                    </span>
                </div>

                <div class="p-3 text-gray-600 border-gray-200 sm:bg-white sm:shadow sm:rounded-lg sm:border">
                    <h3 class="text-xl font-semibold text-blue-600">
                        Shop
                    </h3>
                    <div class="px-5 py-2">
                        <ul class="text-blue-600 list-disc">
                            <li>
                                <span class="text-gray-700">
                                    Shop products and services.
                                </span>
                            </li>

                            <li>
                                <span class="text-gray-700">
                                    Easy shopping with a cart system.
                                </span>
                            </li>

                            <li>
                                <span class="text-gray-700">
                                    Advertise used products for sale. (coming soon).
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <a href="{{ ($maintainanceMode) ? __('#') : __('/shop') }}">
                            <x-jet-button class="mt-2 bg-blue-600 w-100">
                                <i class="fas fa-shopping-bag"></i> &nbsp; shop
                            </x-jet-button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white sm:bg-transparent">
                <div class="flex justify-center p-2">
                    <span class="fa-stack fa-3x">
                        <i class="text-blue-800 far fa-circle fa-stack-2x"></i>
                        <i class="text-blue-800 fa-stack-1x fas fa-store-alt"></i>
                    </span>
                </div>

                <div class="p-3 text-gray-600 border-gray-200 sm:bg-white sm:shadow sm:rounded-lg sm:border">
                    <h3 class="text-xl font-semibold text-blue-800">
                        Build and manage businesses
                    </h3>
                    <div class="px-5 py-2">
                        <ul class="text-blue-800 list-disc">
                            <li>
                                <span class="text-gray-700">
                                    Build an online presence for your business.
                                </span>
                            </li>

                            <li>
                                <span class="text-gray-700">
                                    Unite fun and business.
                                </span>
                            </li>

                            <li>
                                <span class="text-gray-700">
                                    Interact with your customers.
                                </span>
                            </li>

                            <li>
                                <span class="text-gray-700">
                                    Leverage on a virtual warehouse for product management.
                                </span>
                            </li>

                            <li>
                                <span class="text-gray-700">
                                    Deploy a team to manage your business.
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <a href="{{ ($maintainanceMode) ? __('#') : route('manager.dashboard') }}">
                            <x-jet-button class="mt-2 bg-blue-800 w-100">
                                <i class="fas fa-business-time"></i> &nbsp; build a business
                            </x-jet-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
