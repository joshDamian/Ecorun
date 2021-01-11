<x-social-layout>
    <div>
        <div>
            @if($profile->isUser())
            <div class="flex justify-center p-4 bg-gray-200">
                <div class="border-t-4 border-b-4 border-blue-700 rounded-full w-36 h-36 md:h-44 md:w-44"
                    style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                </div>
            </div>
            @else
            <div class="w-full h-56 sm:h-96 md:h-80"
                style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
            </div>
            @endif

            <div onblur="console.log('hi')" class="px-4 py-4 bg-gray-100 border-t-2 border-gray-200">
                <div class="flex flex-wrap items-start justify-between">
                    <div class="flex-1 mr-3 font-semibold">
                        <span class="block text-lg text-blue-800 sm:text-xl">{{ $profile->name }}</span>
                        <span class="grid grid-cols-1 text-sm text-gray-600">
                            <span class="truncate">
                                {{ $profile->full_tag() }}
                            </span>
                            <span class="">
                                @livewire('connect.profile.following-followers-counter',
                                ['profile'=> $profile])
                            </span>
                            <span class="mt-2">
                                Joined {{ $profile->created_at->diffForHumans() }}
                            </span>
                        </span>
                    </div>

                    <div>
                        @livewire('connect.profile.follow-profile', ['profile' => $profile], key('follow_button'))
                    </div>
                </div>
            </div>

            <div class="mt-1">
                @if($profile->isBusiness())
                <div>
                    @livewire('connect.profile-dashboard.business-profile-data', ['profile' => $profile, 'action_route'
                    => $action_route ?? 'products'])
                </div>
                @else
                <div>
                    @livewire('connect.profile-dashboard.user-profile-data', ['profile' => $profile, 'action_route' =>
                    $action_route ?? 'posts'])
                </div>
                @endif
            </div>
        </div>
    </div>
</x-social-layout>
