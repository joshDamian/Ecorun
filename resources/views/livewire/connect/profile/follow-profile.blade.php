<div>
    @cannot('update', $profile)
    @if($this->isFollowing())
    <x-jet-button wire:click="follow" class="bg-blue-800 rounded">
        {{ __('unfollow') }}
    </x-jet-button>

    @else
    @auth
    <x-jet-button wire:click="follow" class="bg-blue-800 rounded">
        <i class="fas fa-plus"></i> &nbsp; {{ __('follow') }}
    </x-jet-button>
    @endauth

    @guest
    <form method="POST" action="{{ route('guest.follow-profile', ['tag' => $profile->tag]) }}">
        @method('PUT')
        @csrf

        <!-- Hidden Profile ID -->
        <input type="hidden" name="profile_id" value="{{ $profile->id }}">
        <x-jet-button onclick="event.preventDefault(); this.closest('form').submit();" class="bg-blue-800 rounded">
            <i class="fas fa-plus"></i> &nbsp; {{ __('follow') }}
        </x-jet-button>
    </form>
    @endguest
    @endif
    @endcannot

    @can('update', $profile)
    <a href="{{ route('profile.edit', ['profile' => $profile->tag, 'user' => request()->user()->profile->data_slug('name')]) }}">
        <x-jet-button wire:click="follow" class="bg-blue-800 rounded">
            {{ __('edit profile') }} &nbsp; <i class="fas fa-user-edit"></i>
        </x-jet-button>
    </a>
    @endcan
</div>