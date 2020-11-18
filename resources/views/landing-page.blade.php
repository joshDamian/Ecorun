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
    @guest
    <nav class="bg-white sticky top-0 border-b-4 border-blue-800">
        <div x-data="{ visible: null }" x-cloak>
            <ul class="flex p-2">
                <li class="font-bold text-xl flex-1 text-blue-800">Logo</li>
                <li class="text-right">
                    <div x-show.transition="visible" class="flex flex-wrap">
                        <a class="mr-4" href="/login">
                            <x-jet-button class="bg-blue-800">
                                Login
                            </x-jet-button>
                        </a>

                        <a href="/register">
                            <x-jet-button class="bg-green-700">
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
                    <h3 class="text-3xl font-medium text-gray-800 px-3 py-2">
                        Connect with people, buy products and build social business networks.
                    </h3>

                    <div class="flex px-3 mb-4 flex-wrap">
                        <a class="mr-4" href="/login">
                            <x-jet-button class="bg-blue-800">
                                Login
                            </x-jet-button>
                        </a>

                        <a href="/register">
                            <x-jet-button class="bg-green-700">
                                Signup
                            </x-jet-button>
                        </a>
                    </div>
                </div>

                <div class="p-3 grid grid-cols-3 gap-1">
                    <div>
                        <div class="flex justify-center items-center p-2 bg-white bg-opacity-75">
                            <i style="font-size: 3rem;" class="fas text-blue-800 fa-user-friends"></i>
                        </div>
                        <div class="bg-blue-800 text-white text-center">social</div>
                    </div>

                    <div>
                        <div class="flex justify-center items-center p-2 bg-white bg-opacity-75">
                            <span style="font-size: 2rem;" class="text-blue-800 font-semibold">&#8358;</span>
                        </div>

                        <div class="bg-blue-800 text-white text-center">business</div>
                    </div>

                    <div>
                        <div class="flex justify-center items-center p-2 bg-white bg-opacity-75">
                            <i style="font-size: 3rem;" class="fas text-blue-800 fa-network-wired"></i>
                        </div>
                        <div class="bg-blue-800 text-white text-center">network</div>
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
                    <h3 class="text-lg text-center font-semibold text-blue-800">
                        <i class="fas fa-user-friends"></i> &nbsp; Connect
                    </h3>

                    <div class="flex justify-center">
                        <div>
                            {{-- <div class="py-2">
                                <ul class="list-disc">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white sm:bg-transparent">
                <div class="p-3 sm:p-0">
                    <img class="w-full" src="/storage/app-images/shop.png" />
                </div>

                <div class="p-3 border-gray-300 sm:border text-gray-600">
                    <h3 class="text-lg text-center font-semibold text-blue-800">
                        <span class="font-bold">&#8358;</span> &nbsp; Buy
                    </h3>

                    <div class="flex justify-center">
                        <div>
                            {{-- <div class="py-2">
                                <ul class="list-disc">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div> --}}

                            <div>
                                <x-jet-button class="bg-blue-800 w-100 mt-2">
                                    visit shop
                                </x-jet-button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-white sm:bg-transparent">
                <div class="p-3 sm:p-0">
                    <img class="w-full" src="/storage/app-images/online-community_6.jpeg" />
                </div>

                <div class="p-3 border-gray-300 text-gray-600 sm:border">
                    <h3 class="text-lg font-semibold text-center text-blue-800">
                        <i class="fas fa-network-wired"></i> &nbsp; Build a social business network
                    </h3>
                    <div class="flex justify-center px-4 py-2">
                        <ul class="list-disc text-blue-800">
                            <li>
                                <span class="text-gray-700">
                                    Build a virtual presence for your business.
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
                                    L
                                </span>
                            </li>

                            <li>
                                <span class="text-gray-700">
                                    D
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </main>
    @endguest

    @stack('modals')

    @livewireScripts

    @stack('scripts')
</body>

</html>
