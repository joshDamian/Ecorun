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
    <style>
        [x-cloak] {
            display: none;
        }

    </style>

    @stack('styles')
    @livewireStyles

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
</head>

<body class="font-sans leading-normal bg-gray-200 tracking-normal">
    <div x-data="nav_data()" x-init="init_nav()" x-cloak>
        <!--Nav-->
        <x-navbar />

        <div class="md:flex md:px-12 md:pt-12 justify-center justify-items-center">
            <div x-show="active_item" class="md:w-1/4 md:fixed absolute w-full bg-white md:bg-transparent md:p-0 md:pr-2 md:left-12">
                <div class="h-screen">
                    <x-nav-content />
                </div>
            </div>

            <div class="w-full md:ml-80 md:pl-2 flex-1">
                <div>
                    @livewire('session-transport', key('session_transport'))
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
                active_item: null
                , init_nav() {
                    if (window.outerWidth > 640) {
                        return this.active_item = 'user';
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
