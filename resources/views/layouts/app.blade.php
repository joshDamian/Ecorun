<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/webfonts.css') }}">
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">

    @stack('styles')
    @livewireStyles

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
</head>

<body class="font-sans leading-normal tracking-normal mt-12">

    <!--Nav-->
    <nav class="bg-gray-900 pt-2 md:pt-1 pb-1 px-1 mt-0 h-auto fixed w-full z-20 top-0">

        <div class="flex flex-wrap relative items-center">
            <div class="flex flex-shrink md:w-1/3 justify-center md:justify-start text-white">
                <a href="/">
                    <span class="text-xl truncate pl-2">
                        <i class="fas fa-store-alt"></i>
                        <span class="hidden">
                            {{ config('app.name') }}
                        </span>
                    </span>
                </a>
            </div>
            @livewire('search-request-receptor')

            <div class="flex w-full pt-2 content-center justify-between md:w-1/3 md:justify-end">
                <ul class="list-reset flex @auth justify-between @endauth  flex-1 md:flex-none items-center">
                    @auth
                    <li class="flex-1 flex-grow md:flex-none md:mr-3">
                        <a class="inline-block py-2 pl-3 pr-4 @if(request()->routeIs('dashboard')) sm:bg-green-900 text-green-400 sm:text-white @else  text-white  bg-gray-900 @endif  hover:bg-green-900 shadow rounded-md no-underline"
                            href="/dashboard">Dashboard</a>
                    </li>

                    @can('own-enterprise')
                    <li class="mr-6 md:flex-none md:mr-6">
                        <x-jet-dropdown align="top">
                            <x-slot name="trigger">
                                <div class="cursor-pointer text-white select-none">
                                    {{ __('manager actions') }}&nbsp;
                                    <i :class="open ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
                                </div>
                            </x-slot>
                            <x-slot name="content">
                                <div class="bg-gray-900 text-white mt-3 p-3 overflow-auto">
                                    <div x-data="{ show_enterprises: false }">
                                        <a @click="show_enterprises = ! show_enterprises"
                                            class="p-2 hover:bg-gray-800 cursor-pointer text-white text-sm no-underline hover:no-underline block">
                                            <span class="truncate">manage businesses</span>
                                            &nbsp;<i
                                                :class="show_enterprises ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
                                        </a>
                                        <div x-show="show_enterprises">

                                            @foreach (Auth::user()->isManager->enterprises()->orderBy('name',
                                            'ASC')->get() as $enterprise)
                                            <a href="{{ route('enterprise.dashboard', ['enterprise' => $enterprise->id, 'active_action' => 'products']) }}"
                                                class="p-2 hover:bg-gray-800
                                                text-white text-sm no-underline hover:no-underline block">
                                                {{ $enterprise->name }}
                                            </a>
                                            @if(!$loop->last)
                                            <div class="border border-gray-800"></div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- <div class="border border-gray-800"></div>
                                    <a href="#"
                                        class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i
                                            class="fa fa-user-tie fa-fw"></i> Manager Account</a>
                                    <div class="border border-gray-800"></div>
                                    <a href="#"
                                        class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i
                                            class="fas fa-sign-out-alt fa-fw"></i> Log Out</a> --}}
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </li>
                    @endcan

                    <li class="flex-1 md:flex-none md:mr-3">
                        <div class="relative inline-block">
                            <button onclick="toggleDD('myDropdown')" class="drop-button text-white focus:outline-none">
                                {{ Auth::user()->name }}
                                <svg class="h-3 fill-current inline" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg></button>
                            <div id="myDropdown"
                                class="dropdownlist absolute bg-gray-900 text-white right-0 mt-3 p-3 overflow-auto z-30 invisible">
                                <input type="text" class="drop-search p-2 text-gray-600" placeholder="Search.."
                                    id="myInput" onkeyup="filterDD('myDropdown','myInput')">
                                <a href="/user/profile"
                                    class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i
                                        class="fa fa-user fa-fw"></i> Profile</a>
                                <div class="border border-gray-800"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt fa-fw"></i> {{ __('Logout') }}
                                    </x-jet-dropdown-link>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endauth
                    @guest
                    <li class="ml-2 pb-1 md:ml-0 md:flex-none md:mr-3">
                        <a href="{{ route('login') }}">
                            <x-jet-button class="bg-green-700 hover:bg-pink-700">
                                {{ __('Login') }}
                            </x-jet-button>
                        </a>
                    </li>

                    <li class="ml-3 pb-1 md:ml-0 md:flex-none md:mr-3">
                        <a href="{{ route('register') }}">
                            <x-jet-button class="bg-blue-700 hover:bg-purple-700">
                                {{ __('Sign Up') }}
                            </x-jet-button>
                        </a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>

    </nav>
    <main>
        {{ $slot }}
    </main>
    <script>
        /*Toggle dropdown list*/
        function toggleDD(myDropMenu) {
            document.getElementById(myDropMenu).classList.toggle("invisible");
        }
        /*Filter dropdown options*/
        function filterDD(myDropMenu, myDropMenuSearch) {
            var input,
                filter,
                ul,
                li,
                a,
                i;
            input = document.getElementById(myDropMenuSearch);
            filter = input.value.toUpperCase();
            div = document.getElementById(myDropMenu);
            a = div.getElementsByTagName("a");
            for (i = 0; i < a.length; i++) {
                if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
        }
        // Close the dropdown menu if the user clicks outside of it
        window.onclick = function (event) {
            if (!event.target.matches('.drop-button') && !event.target.matches('.drop-search')) {
                var dropdowns = document.getElementsByClassName("dropdownlist");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (!openDropdown.classList.contains('invisible')) {
                        openDropdown.classList.add('invisible');
                    }
                }
            }
        }

    </script>
    @stack('modals')

    @livewireScripts

    @stack('scripts')
</body>

</html>
