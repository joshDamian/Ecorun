<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link preload rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" defer>

    <!-- Styles -->
    <link preload rel="stylesheet" href="/css/app.css" defer>
    <link preload rel="stylesheet" href="/css/webfonts.css" defer>

    @stack('styles')
    @livewireStyles

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>
    <script src="/js/app.js" defer></script>

    @env('local')
    <script src="//cdn.jsdelivr.net/npm/eruda"></script>
    <script>
        eruda.init();

    </script>
    @endenv
</head>

<body class="font-sans leading-relaxed tracking-normal bg-gray-200 bg-opacity-75">
    {{$slot}}
    @stack('modals')
    @livewireScripts
    @stack('scripts')
    <script>
        document.addEventListener('livewire:load', () => {
            Echo.channel('posts').listen('PostCreated', (e) => {
                console.log(e.post.content);
            });
        })

    </script>
</body>
</html>
