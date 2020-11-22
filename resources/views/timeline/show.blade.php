<x-app-layout>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 md:gap-3">
        <div class="">
            @if ($profile->isUser())
            <div class="flex p-4 bg-gray-100 sm:shadow-sm sm:rounded-md justify-center">
                <div class="w-44 h-44 rounded-full" style="background-image: url('{{ $profile->profile_image() }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                </div>
            </div>
            @else
            <div class="w-full h-64 sm:rounded-md" style="background-image: url('{{ $profile->profile_image() }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;"></div>
            @endif
            <div class="p-2 bg-gray-100 sm:rounded-md sm:shadow-sm mt-2 md:mt-3">
                <div class="flex justify-between items-center">
                    <div class="mr-3 text-blue-800 text-xl font-semibold">
                        {{ $profile->name() }}
                    </div>

                    <div class="">
                        @livewire('profile.follow', ['profile' => $profile], key('follow_button'))
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-100  sm:shadow-sm sm:rounded-md">
            <p class="text-lg border-b p-2 font-medium border-gray-300 text-gray-600">
                About {{ $profile->name() }}
            </p>
            <p class="text-gray-700 p-2 text-md">
                {{ $profile->description }}
            </p>
        </div>
    </div>

    @if($profile->isEnterprise())
    <div>
        @livewire('timeline.enterprise-data', ['enterprise' => $profile->profileable, 'active_view' => $active_view])
    </div>

    @elseif($profile->isUSer())
    <div>
        @livewire('timeline.user-data', ['user' => $profile->profileable, 'active_view' => $active_view])
    </div>
    @endif
</x-app-layout>
