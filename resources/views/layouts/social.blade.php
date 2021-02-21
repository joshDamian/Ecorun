<x-app-layout>
    <div x-on:resize.window="expand()" x-data="nav_data()" x-init="init_nav()" x-cloak>
        <!--Nav-->
        <x-navbar :user="$user" />
        <div class="justify-between md:flex md:px-4 md:pt-4 justify-items-center">
            @php $associatedProfiles = $user->associated_profiles; @endphp
            <div x-show="open_menu"
                class="fixed top-0 z-50 flex-grow-0 flex-shrink w-full h-full pb-2 overflow-y-auto bg-white shadow md:z-0 md:h-10/12 md:w-1/4 md:pb-1/12 md:top-16 md:bg-transparent md:pr-3 md:left-5">
                <div class="overscroll-none static">
                    <x-nav-content :associatedProfiles="$associatedProfiles" />
                </div>
            </div>

            <div x-ref="main" :class="{ 'hidden md:block': (open_menu || open_notifications) }"
                class="md:flex-1 md:flex-grow md:flex-shrink-0 w-full md:h-full md:ml-1/4 md:mr-1/4 md:pr-4 md:pl-6 sm:p-2 md:p-0">
                <div>
                    {{-- @livewire('general.session.session-transport',
                    key('session_transport')) --}}
                </div>
                <main class="w-full">
                    {{ $slot }}
                </main>
            </div>
            @auth
            <div x-show="open_notifications"
                class="fixed top-0 z-50 flex-grow-0 flex-shrink w-full h-full pb-2 overflow-y-auto bg-white shadow md:z-0 md:h-10/12 md:pb-1/12 md:w-1/4 md:top-16 md:bg-transparent md:pl-2 md:right-5">
                <div>
                    <livewire:general.user.notifications :user="$user"
                        :activeProfile="$associatedProfiles->current_profile" />
                </div>
            </div>
            @endauth
        </div>
    </div>
    <script>
        function nav_data() {
            return {
                open_menu: false,
                open_notifications: false,
                scrollPostition: 0,
                init_nav() {
                    this.expand();
                    this.$watch('open_menu', result => {
                        if (result && window.outerWidth < 768) {
                            this.scrollPostition = window.pageYOffset;
                            this.$refs.main.style.top = -this.scrollPostition + 'px';
                        } else if (!result && window.outerWidth < 768) {
                            setTimeout(() => {
                                window.scrollTo(0, this.scrollPostition);
                                this.$refs.main.style.top = 0;
                            }, 10);
                        }
                    })

                    this.$watch('open_notifications',
                        result => {
                            if (result && window.outerWidth < 768) {
                                this.scrollPostition = window.pageYOffset;
                                this.$refs.main.style.top = -this.scrollPostition + 'px';
                            } else if (!result && window.outerWidth < 768) {
                                setTimeout(() => {
                                    window.scrollTo(0, this.scrollPostition);
                                    this.$refs.main.style.top = 0;
                                }, 10);
                            }
                        }
                    )
                },
                expand() {
                    if (window.outerWidth >= 768) {
                        this.open_notifications = true;
                        this.open_menu = true;
                    }
                },
            }
        }

    </script>
</x-app-layout>