<x-app-layout>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 md:gap-3">
        <div class="sm:col-span-2">
            @if ($profile->isUser())
            <div class="flex pt-4 md:pt-0 justify-center">
                <div class="p-1 bg-blue-600 bg-opacity-50 rounded-full shadow-md">
                    <div class="w-44 h-44 md:h-64 md:w-64 rounded-full" style="background-image: url('{{ $profile->profile_image() }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
                    </div>
                </div>
            </div>
            @else
            <div class="w-full h-64 sm:rounded-md" style="background-image: url('{{ $profile->profile_image() }}'); background-size: cover; background-position: center center; background-repeat: no-repeat;"></div>
            @endif
            <div class="sm:rounded-md mt-2 p-2 md:p-0 md:mt-3">
                <div class="flex justify-between items-center">
                    <div class="mr-3 text-blue-800 text-xl font-semibold">
                        {{ $profile->name() }}
                    </div>

                    <div class="">
                        @livewire('profile.follow', ['profile' => $profile], key('follow_button'))
                    </div>
                </div>
            </div>
            <div class="md:mt-1">
                @if($profile->isEnterprise())
                <div>
                    @livewire('timeline.enterprise-data', ['enterprise' => $profile->profileable, 'active_view' => $active_view])
                </div>

                @elseif($profile->isUSer())
                <div>
                    @livewire('timeline.user-data', ['user' => $profile->profileable, 'active_view' => $active_view])
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
