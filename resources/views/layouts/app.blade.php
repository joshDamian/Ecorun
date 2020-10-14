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
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">

    @livewireStyles

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
</head>

<body class="bg-gray-900 font-sans leading-normal tracking-normal mt-12">

    <!--Nav-->
    <nav class="bg-gray-900 pt-2 md:pt-1 pb-1 px-1 mt-0 h-auto fixed w-full z-20 top-0">

        <div class="flex flex-wrap items-center">
            <div class="flex flex-shrink md:w-1/3 justify-center md:justify-start text-white">
                <a href="#">
                    <span class="text-xl pl-2"><i class="em em-grinning"></i></span>
                </a>
            </div>

            <div class="flex flex-1 md:w-1/3 justify-center md:justify-start text-white px-2">
                <span class="relative w-full">
                    <input type="search" placeholder="Search"
                        class="w-full bg-gray-800 text-sm text-white transition border border-transparent focus:outline-none focus:border-gray-700 rounded py-1 px-2 pl-10 appearance-none leading-normal">
                    <div class="absolute search-icon" style="top: .5rem; left: .8rem;">
                        <svg class="fill-current pointer-events-none text-white w-4 h-4"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z">
                            </path>
                        </svg>
                    </div>
                </span>
            </div>

            <div class="flex w-full pt-2 content-center justify-between md:w-1/3 md:justify-end">
                <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
                    <li class="flex-1 md:flex-none md:mr-3">
                        <a class="inline-block py-2 px-4 @if(request()->routeIs('dashboard')) text-green-300 @else text-gray-600 hover:text-gray-200 hover:text-underline @endif no-underline"
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
                                            <a href="{{ route('enterprise-dashboard', ['enterprise' => $enterprise->id]) }}"
                                                class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block">
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
            var input, filter, ul, li, a, i;
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
