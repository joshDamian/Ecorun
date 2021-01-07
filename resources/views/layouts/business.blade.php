<x-app-layout>
    <div x-on:resize.window="expand()" x-data="nav_data()" x-init="init_nav()" x-cloak>
        <!--Nav-->
        <x-navbar :user="$user" />

        <div class="justify-between md:flex md:px-4 md:pt-4 justify-items-center">

            <div x-show="open_menu" :class="(open_menu) ? 'w-full md:w-1/4' : 'w-0'"
                class="fixed top-0 h-full flex-1 flex-grow-0 flex-shrink overflow-y-auto bg-white animate__animated animate__slideInLeft md:top-16 md:bg-transparent md:pr-3 md:left-5">
                <div>
                    @php $associatedProfiles = $user->associated_profiles; @endphp
                    <x-nav-content :associatedProfiles="$associatedProfiles" />
                </div>
            </div>

            <div :class="(open_menu || open_notifications) ? 'hidden md:block' : ''"
                class="flex-1 flex-grow flex-shrink-0 w-full md:ml-1/4 md:pl-6 sm:p-2 md:p-0">
                <div>
                    {{-- @livewire('general.session.session-transport', key('session_transport')) --}}
                </div>

                <main class="w-full">
                    {{ $slot }}
                </main>
            </div>

            <div x-show="open_notifications"
                :class="(open_notifications) ? 'w-full md:w-1/4' : 'w-0'"
                class="fixed top-0 h-full flex-1 flex-grow-0 flex-shrink overflow-y-auto bg-white md:shadow-2xl animate__animated animate__slideInRight md:top-16 md:right-5">
                <livewire:general.user.notifications :user="$user"
                    :activeProfile="$associatedProfiles->current_profile" />
            </div>
        </div>
    </div>

    <script>
        function nav_data() {
            return {
                open_menu: null,
                open_notifications: null,
                init_nav() {
                    return this.expand()
                },
                expand() {
                    if (window.outerWidth > 768) {
                        return this.open_menu = true;
                    }
                }
            }
        }

    </script>
</x-app-layout>