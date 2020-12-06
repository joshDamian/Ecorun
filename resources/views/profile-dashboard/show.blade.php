<x-app-layout>
    <div class="grid grid-cols-1 gap-2 sm:grid-cols-3 md:gap-3">
        <div class="sm:col-span-2">
            @if ($profile->isUser())

            <div class="flex justify-center p-4 bg-gray-200 md:p-0 md:pb-4">
                <div class="border-t-4 border-b-4 border-blue-700 rounded-full w-44 h-44 md:h-48 md:w-48" style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                </div>
            </div>

            @else
            <div class="w-full h-64" style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;"></div>
            @endif

            <div class="px-4 py-4 bg-gray-100 border-t-2 border-gray-200 md:px-4">
                <div class="flex items-center justify-between">
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

                @elseif($profile->isUSer())
                <div>
                    @livewire('connect.profile-dashboard.user-profile-data', ['user' => $profile->profileable, 'active_view' => $active_view])
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
