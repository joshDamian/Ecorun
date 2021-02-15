<x-social-layout>
    <div class="sticky text-blue-700 font-bold top-12 bg-white p-2">
        {{ ($profile->id === auth()->user()->currentProfile->id) ? __('Your') : $profile->full_tag() . '\'s' }} followers.
    </div>

    <div class="p-2 bg-gray-200 grid grid-cols-1 gap-2">
        @forelse($followers as $follower)
        @include('includes.profile-display-cards.search-result-display-card', ['model' => $follower])
        @empty
        <div class="p-4 text-blue-700">
            <div class="flex justify-center items-center">
                <i style="font-size: 4rem;" class="far fa-user"></i>
            </div>

            <div class="text-center mt-3 font-bold">
                {{ ($profile->id === auth()->user()->currentProfile->id) ? __('You have no followers yet.') : $profile->full_tag() . ' has no followers yet.' }}
            </div>
        </div>
        @endforelse
    </div>

    <div class="mx-2 mb-2 md:mx-0">
        <x-paginator :data="$followers" />
    </div>
</x-social-layout>