<x-app-layout>
    <div x-on:resize.window="expand()" x-data="nav_data()" x-init="init_nav()" x-cloak>
        <!--Nav-->
        <x-navbar :user="$user" />

        <div class="justify-between md:flex md:px-4 md:pt-4 justify-items-center">

            <div x-show="open_menu"
                class="fixed top-0 z-50 flex-grow-0 flex-shrink w-full h-full pb-2 overflow-y-auto bg-white shadow md:z-0 md:h-10/12 md:w-1/4 md:pb-1/12 md:top-16 md:bg-transparent md:pr-3 md:left-5">
                <div>
                    @php $associatedProfiles = $user->associated_profiles; @endphp
                    <x-nav-content :associatedProfiles="$associatedProfiles" />
                </div>
            </div>

            <div class="flex-1 flex-grow flex-shrink-0 md:ml-1/4 md:pl-6 sm:p-2 md:p-0">
                <div>
                    {{-- @livewire('general.session.session-transport', key('session_transport')) --}}
                </div>

                <main>
                    {{ $slot }}
                </main>
            </div>

            @auth
            <div x-show="open_notifications"
                class="fixed top-0 z-50 flex-grow-0 flex-shrink w-full h-full pb-2 overflow-y-auto bg-white shadow md:h-10/12 md:pb-1/12 md:w-1/4 md:top-16 md:bg-transparent md:pl-2 md:right-5">
                <livewire:general.user.notifications :user="$user"
                    :activeProfile="$associatedProfiles->current_profile" />
            </div>
            @endauth
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
