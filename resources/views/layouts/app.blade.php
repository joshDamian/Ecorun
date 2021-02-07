<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Ecorun naturally blends social interaction with doing business.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1E40AF">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="Ecorun" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#0000ff" />

    <title>{{ config('app.name', 'Ecorun') }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="manifest" href="manifest.json">
    <link rel="icon" href="/icon/logo.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="/icon/logo_180.png">


    <!-- Fonts -->
    <link preload rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" />

    <!-- Styles -->
    <link preload rel="stylesheet" href="/css/app.css" defer>
    <link preload rel="stylesheet" href="/css/webfonts.css" defer>

    @stack('styles')

    <style>
        .text-content a {
            color: rgb(13, 71, 197);
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

    @env('local')
    <script src="https://cdn.jsdelivr.net/npm/eruda"></script>
    <script>
        eruda.init();

    </script>
    @endenv
</head>

<body class="font-sans leading-relaxed tracking-normal bg-gray-200 bg-opacity-75">
    @livewire('buy.cart.add-to-cart', key(md5('add_a_product_to_cart')))
    {{$slot}}

    <script type="module" src="https://cdn.jsdelivr.net/npm/@pwabuilder/pwaupdate"></script>

    <div class="relative z-50">
        <pwa-update swpath="/pwabuilder-sw.js"></pwa-update>
    </div>

    <div x-data="pwa_install_data()" x-init="init_pwa()" x-show="!hide" style="z-index: 45;"
        class="fixed bottom-0 flex justify-center w-full p-3 bg-gray-100 md:w-auto" x-cloak>
        <x-jet-button x-ref="pwa_btn" id="pwa_install" class="bg-blue-700">
            Add To Apps.
        </x-jet-button>

        <div class="ml-6">
            <i @click="hide = true;" class="text-lg text-gray-500 fas fa-times"></i>
        </div>
    </div>
    @stack('modals')
    @livewireScripts
    @stack('scripts')

    @env('production')
    <script>
        // Check that service workers are supported
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/pwabuilder-sw.js').then(console.log('service worker registered'));
        }

        function pwa_install_data() {
            return {
                hide: true,
                init_pwa: function() {
                    let deferredPrompt;
                    window.addEventListener('beforeinstallprompt', (e) => {
                        // Prevent Chrome 67 and earlier from automatically showing the prompt
                        e.preventDefault();
                        // Stash the event so it can be triggered later.
                        deferredPrompt = e;
                        // Update UI to notify the user they can add to home screen
                        this.hide = false;

                        this.$refs.pwa_btn.addEventListener('click', (e) => {
                            // hide our user interface that shows our A2HS button
                            this.hide = true;
                            // Show the prompt
                            deferredPrompt.prompt();
                            // Wait for the user to respond to the prompt
                            deferredPrompt.userChoice.then((choiceResult) => {
                                if (choiceResult.outcome === 'accepted') {
                                    console.log('User accepted the A2HS prompt');
                                } else {
                                    console.log('User dismissed the A2HS prompt');
                                }
                                deferredPrompt = null;
                            });
                        });
                    });
                }
            }
        }
    </script>
    @endenv
</body>

</html>