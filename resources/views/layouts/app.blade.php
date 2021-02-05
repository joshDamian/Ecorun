<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Ecorun naturally blends social interaction with doing business.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="manifest" href="/manifest.json">


    <!-- Fonts -->
    <link preload rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" />
    <!-- Styles -->
    <link preload rel="stylesheet" href="/css/app.css" defer>
    <link preload rel="stylesheet" href="/css/webfonts.css" defer>

    @stack('styles')

    <style>
        .text-content a {
            color: rgb(18, 18, 151);
            font-weight: 900;
        }

        .rm-p-bottom-gap p {
            margin-bottom: -0.86rem;
        }

        .dont-break-out {
            /* These are technically the same, but use both */
            overflow-wrap: break-word;
            word-wrap: break-word;

            /* Instead use this non-standard one: */
            word-break: break-word;
        }

        .form-textarea {
            margin-bottom: -0.5rem;
        }

        .carousel-cell {
            width: 100%;
            height: 400px;
        }

        .carousel-post-feed {
            width: 100%;
            margin-right: 10px;
            height: 350px;
        }

        progress[value] {
            -webkit-appearance: none;
            appearance: none;
        }

        progress[value]::-webkit-progress-value {
            background: rgb(9, 36, 160);
        }

        .carousel-cell-image {
            display: block;
            max-height: 100%;
            margin: 0 auto;
            max-width: 100%;
            opacity: 0;
            -webkit-transition: opacity 0.4s;
            transition: opacity 0.4s;
        }

        /* fade in lazy loaded image */
        .carousel-cell-image.flickity-lazyloaded,
        .carousel-cell-image.flickity-lazyerror {
            opacity: 1;
        }

        @-moz-document url-prefix() {
            .form-textarea {
                margin-bottom: -0.1rem;
            }
        }

        .line-clamp {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    @livewireStyles

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.js" defer></script>
    <script src="/js/app.js" defer></script>
    <script type="module" src="/pwabuilder-sw-register.js"></script>

    @env('local')
    <script src="//cdn.jsdelivr.net/npm/eruda"></script>
    <script>
        eruda.init();

    </script>
    @endenv
</head>

<body class="font-sans leading-relaxed tracking-normal bg-gray-200 bg-opacity-75">
    @livewire('buy.cart.add-to-cart', key(md5('add_a_product_to_cart')))
    {{$slot}}
    @stack('modals')
    @livewireScripts
    @stack('scripts')

    {{-- <script>
        // Check that service workers are supported
        if ('serviceWorker' in navigator) {
        // Use the window load event to keep the page load performant
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/pwabuilder-sw.js');
        });
        }
    </script> --}}
</body>

</html>
