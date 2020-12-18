<x-app-layout>
    <div x-on:resize.window="expand()" x-data="nav_data()" x-init="init_nav()" x-cloak>
        <!--Nav-->
        <x-navbar />

        <div class="justify-between md:flex md:px-4 md:pt-4 justify-items-center">

            <div x-show="open_menu" :class="(open_menu) ? 'w-full md:w-1/4' : 'w-0'" style="height: 98vh;" class="fixed top-0 flex-1 flex-grow-0 flex-shrink overflow-y-auto bg-white animate__animated animate__slideInLeft md:top-16 md:bg-transparent md:pr-3 md:left-5">
                <div class="pb-1/5">
                    <x-nav-content />
                </div>
            </div>

            <div :class="(open_menu || open_notifications) ? 'hidden md:block' : ''" class="flex-1 flex-grow flex-shrink-0 w-full md:ml-1/4 md:mr-1/4 md:pr-4 md:pl-6 sm:p-2 md:p-0">
                <div>
                    @livewire('general.session.session-transport', key('session_transport'))
                </div>

                <main class="w-full">
                    {{ $slot }}
                </main>
            </div>

            <div style="height: 98vh;" :class="(open_notifications) ? 'w-full md:w-1/4' : 'w-0'" class="fixed top-0 flex-1 flex-grow-0 flex-shrink overflow-y-auto bg-white pb-1/6 animate__animated animate__slideInRight md:top-16 md:bg-transparent md:pl-2 md:right-5">
                <div class="sticky top-0 p-2 text-left text-white bg-blue-800 md:hidden">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 text-lg font-bold text-center">
                            Notifications
                        </div>
                        <i @click=" open_notifications = false; Livewire.emit('hideNotifications')" class="ml-3 text-2xl fas fa-times"></i>
                    </div>
                </div>

                @livewire('general.user.notifications')
            </div>
        </div>
    </div>

    <script>
        function nav_data() {
            return {
                open_menu: null
                , open_notifications: null
                , init_nav() {
                    return this.expand()
                }
                , expand() {
                    if (window.outerWidth > 768) {
                        this.open_notifications = true;
                        Livewire.emit('showNotifications');
                        return this.open_menu = true;
                    }
                }
            }
        }

    </script>
</x-app-layout>
