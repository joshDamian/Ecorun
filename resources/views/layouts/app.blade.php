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
    <link href="https://emoji-css.afeld.me/emoji.css" rel="stylesheet">
    <style>
        [x-cloak] {
            display: none;
        }

    </style>

    @stack('styles')
    @livewireStyles

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans leading-relaxed tracking-normal bg-gray-200 bg-opacity-75">
    <div x-on:resize.window="expand()" x-data="nav_data()" x-init="init_nav()" x-cloak>
        <!--Nav-->
        <x-navbar />

        <div class="justify-between md:flex md:px-4 md:pt-4 justify-items-center">

            <div x-show="open" :class="(open) ? 'w-full md:w-1/4' : 'w-0'" class="sticky flex-1 flex-grow-0 flex-shrink h-screen pb-20 overflow-y-auto bg-white md:fixed animate__animated animate__slideInLeft top-12 md:top-16 md:bg-transparent md:pr-3 md:left-5">
                <x-nav-content />
            </div>

            <div class="flex-1 flex-grow flex-shrink-0 w-full md:ml-1/4 md:pl-6 sm:p-2 md:p-0">
                <div>
                    @livewire('general.session.session-transport', key('session_transport'))
                </div>

                <main class="w-full">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </div>

    <script>
        function nav_data() {
            return {
                open: null
                , init_nav() {
                    return this.expand()
                }
                , expand() {
                    if (window.outerWidth > 768) {
                        return this.open = true;
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
