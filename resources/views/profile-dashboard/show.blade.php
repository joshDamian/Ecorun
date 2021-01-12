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

            <div class="px-4 py-4 bg-gray-100 border-t-2 border-gray-200">
                <div class="flex flex-wrap items-start justify-between">
                    <div class="flex-1 mr-3">
                        <div class="text-lg text-blue-800 font-semibold sm:text-xl">
                            {{ $profile->name }}
                        </div>

                        <div class="truncate text-gray-600 text-sm">
                            {{ $profile->full_tag() }}
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex-1 flex-shrink-0">
                            @livewire('connect.profile.follow-profile', ['profile' => $profile], key('follow_button'))
                        </div>
                        @cannot('update', $profile)
                        <div class="flex-shrink-0 ml-3">
                            @livewire('connect.direct-conversation.initiate-conversation', ['initiator' => Auth::user()->currentProfile, 'joined' => $profile])
                        </div>
                        @endcannot
                    </div>
                </div>

                <div class="grid grid-cols-1">
                    <span class="">
                        @livewire('connect.profile.following-followers-counter',
                        ['profile'=> $profile])
                    </span>
                    <span class="mt-2">
                        Joined {{ $profile->created_at->diffForHumans() }}
                    </span>
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