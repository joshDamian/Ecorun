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
            <div class="w-full h-56 sm:h-96 md:h-72"
                style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
            </div>
            @endif

            <div class="px-4 py-4 bg-gray-100 border-t-2 border-gray-200">
                <div class="flex items-start justify-between">
                    <div class="flex-1 mr-3">
                        <div class="text-lg font-semibold text-blue-800 dont-break-out sm:text-xl">
                            {{ $profile->name }}
                        </div>

                        <div class="text-sm text-gray-600 truncate">
                            {{ $profile->full_tag() }}
                        </div>
                    </div>

                    <div class="flex flex-1 flex-shrink-0 items-center">
                        <div class="flex-1 flex-shrink-0">
                            @livewire('connect.profile.follow-profile', ['profile' => $profile], key('follow_button'))
                        </div>

                        @cannot('update', $profile)
                        @auth
                        @php
                        $user = Auth::user();
                        $current_profile = $user->currentProfile;
                        @endphp
                        <div class="flex-shrink-0 ml-3">
                            @if($user->can('create', [\App\Models\DirectConversation::class,
                            $current_profile,
                            $profile]))
                            @livewire('connect.direct-conversation.initiate-conversation', ['initiator' =>
                            $current_profile, 'joined' => $profile])
                            @else
                            <a
                                href="{{ route('chat.index', ['activeConversation' => $current_profile->direct_conversationWith($profile)->secret_key]) }}">
                                <x-jet-button class="bg-blue-600">
                                    <i class="text-lg fas fa-envelope"></i>
                                </x-jet-button>
                            </a>
                            @endif
                        </div>
                        @endauth
                        @endcannot
                    </div>
                </div>

                <div class="grid grid-cols-1">
                    <span class="">
                        @livewire('connect.profile.following-followers-counter',
                        ['profile'=> $profile])
                    </span>
                    <span class="mt-2 text-gray-900">
                        Joined {{ $profile->created_at->diffForHumans() }}
                    </span>
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
