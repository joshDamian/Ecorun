<x-app-layout>
    <div class="pb-16 md:grid md:pb-0 md:grid-cols-3 md:gap-3">
        <div class="md:col-span-2 md:mr-12">
            @if ($profile->isUser())

            <div class="flex justify-center p-4 bg-gray-200">
                <div class="border-t-4 border-b-4 border-blue-700 rounded-full w-44 h-44 md:h-48 md:w-48" style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                </div>
            </div>

            @else
            <div class="w-full h-64" style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;"></div>
            @endif

            <div class="px-4 py-4 bg-gray-100 border-t-2 border-gray-200 md:px-4">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="mr-3 text-xl font-semibold text-blue-800">
                        {{ $profile->name }}
                    </div>

                    <div class="">
                        @livewire('connect.profile.follow-profile', ['profile' => $profile], key('follow_button'))
                    </div>
                </div>
            </div>

            <div class="md:mt-1">
                @if($profile->isBusiness())
                <div>
                    @livewire('connect.profile-dashboard.business-profile-data', ['business' => $profile->profileable, 'active_view' => $active_view])
                </div>

                <div>
                    @livewire('connect.profile-dashboard.user-profile-data', ['user' => $profile->profileable, 'active_view' => $active_view])
                </div>
                @endif
            </div>
        </div>

        <div class="sm:col-span-1">
            <div class="fixed bottom-0 w-full bg-gray-900 md:bg-transparent md:pl-1 md:w-1/4 md:top-20 md:right-12">
                <div class="flex flex-row md:flex-col">
                    @auth
                    <div class="px-2 py-2 mr-1 text-lg font-medium tracking-wider text-left text-blue-800 bg-gray-200 border-b-2 border-gray-200 md:py-3 md:px-4 md:bg-gray-100 md:mr-0 hover:border-blue-700 md:cursor-pointer">
                        <i class="fa fa-clipboard-check"></i> Orders
                    </div>
                    @endauth

                    @auth
                    <a href="/user/profile/edit">
                        <div class="px-2 py-2 md:py-3 md:px-4 tracking-wider text-left @if(request()->routeIs('profile.show')) border-blue-700 @else border-gray-200 @endif
                            bg-gray-200 md:bg-gray-100 font-medium text-lg text-blue-800 hover:border-blue-700 md:cursor-pointer">
                            <i class="fa fa-user-edit"></i> Edit Profile
                        </div>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
