@props(['profile', 'component' => 'jet-dropdown-link'])

<form method="POST" action="{{ route('current-profile.update', ['user' => Auth::user()->profile->data_slug('name')]) }}">
    @method('PUT')
    @csrf

    <!-- Hidden Profile ID -->
    <input type="hidden" name="profile_id" value="{{ $profile->id }}">

    <x-dynamic-component :component="$component" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
        <div class="flex items-center">
            <div class="truncate mr-2 text-blue-700">
                {{ $profile->full_tag() }}
            </div>

            @if (Auth::user()->currentProfile->is($profile))
            <svg class="h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            @endif
        </div>
    </x-dynamic-component>
</form>