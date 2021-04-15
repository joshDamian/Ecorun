<x-social-layout>
    @section('title', "Ecorun | {$profile->name} (@{$profile->tag})'s profile")
    @section('description', "{$profile->name} (@{$profile->tag})'s profile")
    <div x-data="{ zoomedImage: false, show_copy: false }">
        <div>
            @if($profile->isUser())
            <div class="flex justify-center p-4 bg-gray-200">
                <div x-on:click="zoomedImage = '{{ $profile->profile_photo_url }}'"
                    class="border-t-4 border-b-4 border-blue-700 rounded-full cursor-pointer w-36 h-36 md:h-44 md:w-44"
                    style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                </div>
            </div>
            @else
            <div x-on:click="zoomedImage = '{{ $profile->profile_photo_url }}'"
                class="w-full h-56 cursor-pointer sm:h-96 md:h-72"
                style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
            </div>
            @endif

            <template x-if="zoomedImage">
                <div class="fixed inset-0 z-50 flex flex-col w-screen h-screen bg-black md:flex-row">
                    <div class="absolute top-0 w-full px-3 py-1 bg-black bg-opacity-25">
                        <i x-on:click="zoomedImage=false" class="text-2xl text-white cursor-pointer fas fa-times"></i>
                    </div>

                    <div class="flex items-center justify-center flex-1 h-full">
                        <img :src="zoomedImage" class="max-w-full max-h-full" />
                    </div>
                </div>
            </template>

            <div class="px-3 py-3 bg-gray-100 border-t-2 border-gray-200">
                <div class="flex items-start justify-between">
                    <div class="flex-1 mr-3">
                        <div class="text-lg font-semibold text-blue-800 dont-break-out sm:text-xl">
                            {{ $profile->name }} @if($profile->isOnline()) &nbsp; <i
                                class="text-sm text-green-400 fas fa-circle"></i> @endif
                        </div>
                        <div class="text-sm text-gray-600 dont-break-out">
                            {{ $profile->full_tag() }}
                        </div>

                        <div class="py-2 font-bold text-green-500">
                            @php
                            $badge = $profile->profileable?->primaryBadge;
                            @endphp
                            <i class="{{ $badge->icon }}"></i> {{ $badge->label }}
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <div class="flex-1 flex-shrink-0">
                            @livewire('connect.profile.follow-profile', ['profile' => $profile], key('follow_button'))
                        </div>

                        @cannot('update', $profile)
                        @auth
                        @php
                        $user = Auth::user();
                        $current_profile = $user->currentProfile;
                        @endphp
                        <div class="flex-1 flex-shrink-0 ml-3">
                            @if($user->can('create', [\App\Models\DirectConversation::class,
                            $current_profile,
                            $profile]))
                            @livewire('connect.direct-conversation.initiate-conversation', ['initiator' =>
                            $current_profile, 'joined' => $profile],
                            key(md5("initiate_conversation_with_{$profile->
                            id}")))
                            @else
                            <a
                                href="{{ route('chatEngine.talk', ['conversation' => $current_profile->direct_conversationWith($profile)->secret_key, 'me' => $current_profile]) }}">
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
                        ['profile'=> $profile], key(md5("following_followers_for_{$profile->id}")))
                    </span>
                    <div class="grid grid-cols-2">
                        <div class="flex justify-start">
                            <span class="mt-2 text-gray-900">
                                Joined {{ $profile->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <div class="flex justify-end">
                            <div class="text-right">
                                <x-jet-secondary-button x-on:click="show_copy = !show_copy" class="text-blue-700">
                                    copy profile link
                                </x-jet-secondary-button>
                                <x-jet-input class="w-full mt-2" x-show="show_copy"
                                    value="{{ $profile->url->visit }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div :class="{ 'hidden': zoomedImage }" class="mt-1">
            @if($profile->isBusiness())
            <div>
                @livewire('connect.profile-dashboard.business-profile-data', ['profile' => $profile, 'action_route'
                => $action_route ?? 'products'], key(md5("business_profile_data_for_{$profile->id}")))
            </div>
            @else
            <div>
                @livewire('connect.profile-dashboard.user-profile-data', ['profile' => $profile, 'action_route' =>
                $action_route ?? 'posts'], key(md5("user_profile_data_for_{$profile->id}")))
            </div>
            @endif
        </div>
    </div>
</x-social-layout>
