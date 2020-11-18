<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/webfonts.css') }}">
    <link href="https://afeld.github.io/emoji-css/emo7ji.css" rel="stylesheet">
    <style>
        [x-cloak] {
            display: none;
        }

    </style>

    @stack('styles')
    @livewireStyles

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans leading-normal tracking-normal">

    <nav class="bg-white sticky top-0 border-b-4 border-blue-800">
        <div x-data="{ visible: null }" x-cloak>
            <ul class="flex px-3 py-2">
                <li class="font-bold text-xl flex-1 text-blue-800">Logo</li>
                <li class="text-right">
                    <div x-show.transition="visible" class="flex flex-wrap">
                        <a class="mr-4" href="/login">
                            <x-jet-button class="bg-blue-800">
                                Login
                            </x-jet-button>
                        </a>

                        <a href="/register">
                            <x-jet-button class="bg-green-500">
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
            <div class="grid grid-cols-1 sm:p-3 md:p-10 sm:grid-cols-2">
                <div class="">
                    <h3 class="text-3xl font-medium text-gray-800 px-3 sm:px-0 sm:py-0 py-2">
                        Connect with people, buy products, build and manage businesses.
                    </h3>

                    <div class="flex px-3 sm:px-0 mb-4 flex-wrap">
                        <a class="mr-4" href="/login">
                            <x-jet-button class="bg-blue-700">
                                Login
                            </x-jet-button>
                        </a>

                        <a href="/register">
                            <x-jet-button class="bg-green-500">
                                Signup
                            </x-jet-button>
                        </a>
                    </div>
                </div>

                <div class="p-3 grid grid-cols-3 gap-1">
                    <div>
                        <div class="flex justify-center items-center">
                            <span class="fa-stack fa-2x">
                                <i class="fas fa-circle text-green-500 fa-stack-2x"></i>
                                <i class="fas fa-stack-1x text-white fa-user-friends"></i>
                            </span>
                        </div>
                        <div class="text-center font-semibold text-green-500">connect</div>
                    </div>

                    <div>
                        <div class="flex justify-center items-center">
                            <span class="fa-stack fa-2x">
                                <i class="fas fa-circle text-blue-700 fa-stack-2x"></i>
                                <span class="fa-stack-1x text-white font-semibold">&#8358;</span>
                            </span>
                        </div>

                        <div class="text-center font-semibold text-blue-700">buy</div>
                    </div>

                    <div>
                        <div class="flex justify-center items-center">
                            <span class="fa-stack fa-2x">
                                <i class="fas fa-circle text-blue-800 fa-stack-2x"></i>
                                <i class="fas fa-stack-1x text-white fa-warehouse"></i>
                            </span>
                        </div>

                        <div class="text-center font-semibold text-blue-800">build</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 bg-gray-100 sm:p-3 gap-2 sm:gap-3 md:gap-10 md:p-10">
            <div class="bg-white sm:bg-transparent">
                <div class="p-3 sm:p-0">
                    <img class="w-full" src="/storage/app-images/online-community_2.jpeg" />
                </div>

                <div class="p-3 border-gray-300 sm:border text-gray-600">
                    <h3 class="text-xl font-semibold text-green-500">
                        <i class="fas fa-user-friends"></i> &nbsp; Connect
                    </h3>
                    <div class="px-5 py-2">
                        <ul class="list-disc text-green-500">
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
                        </ul>
                    </div>

                    <div>
                        <a href="/register">
                            <x-jet-button class="bg-green-500 w-100 mt-2">
                                <i class="fas fa-plus"></i> &nbsp; join the community
                            </x-jet-button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white sm:bg-transparent">
                <div class="p-3 sm:p-0">
                    <img class="w-full" src="/storage/app-images/shop.png" />
                </div>

                <div class="p-3 border-gray-300 sm:border text-gray-600">
                    <h3 class="text-xl font-semibold text-blue-700">
                        <span class="font-bold">&#8358;</span> &nbsp; Buy
                    </h3>
                    <div class="px-5 py-2">
                        <ul class="list-disc text-blue-700">
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
                        </ul>
                    </div>

                    <div>
                        <a href="/shop">
                            <x-jet-button class="bg-blue-700 w-100 mt-2">
                                <i class="fas fa-shopping-bag"></i> &nbsp; shop
                            </x-jet-button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white sm:bg-transparent">
                <div class="p-3 sm:p-0">
                    <img class="w-full" src="/storage/app-images/remote-business-manager.jpg" />
                </div>

                <div class="p-3 border-gray-300 text-gray-600 sm:border">
                    <h3 class="text-xl font-semibold text-blue-800">
                        <i class="fas fa-warehouse"></i> &nbsp; Build and manage businesses
                    </h3>
                    <div class="px-5 py-2">
                        <ul class="list-disc text-blue-800">
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
                        </ul>
                    </div>

                    <div>
                        <x-jet-button class="bg-blue-800 w-100 mt-2">
                            <i class="fas fa-business-time"></i> &nbsp; build a business
                        </x-jet-button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @stack('modals')

    @livewireScripts

    @stack('scripts')
</body>

</html>
