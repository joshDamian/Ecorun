@props(['profile', 'component' => 'jet-dropdown-link', 'currentProfile'])

<form method="POST" action="{{ route('current-profile.update') }}">
    @method('PUT')
    @csrf

    <!-- Hidden Profile ID -->
    <input type="hidden" name="profile_id" value="{{ $profile->id }}">

    <div @if(!$currentProfile->is($profile)) class="flex items-center self-stretch justify-between place-items-center"
        @endif>
        <div @if(!$currentProfile->is($profile)) class="mr-2" @endif>
            <x-dynamic-component :component="$component" href="#"
                onclick="event.preventDefault(); this.closest('form').submit();">
                <div class="flex items-center">
                    <div class="mr-2 text-blue-800 truncate">
                        {{ $profile->full_tag() }}
                    </div>

                    @if ($currentProfile->is($profile))
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    @endif
                </div>
            </x-dynamic-component>
        </div>

        @if(!$currentProfile->is($profile))
        <div class="flex">
            <a class="mr-3 text-blue-600 underline" href="{{ route('profile.visit', ['profile' => $profile->tag]) }}">
                <i class="far fa-eye"></i>
            </a>

            <a class="mr-3 text-blue-600 underline"
                href="{{ ($profile->isBusiness()) ? route('business.dashboard', ['profile' => $profile->tag, 'action_route' => 'edit']) : route('profile.edit', ['profile' => $profile->tag]) }}">
                <i class="far fa-edit"></i>
            </a>
        </div>
        @endif
    </div>
</form>
