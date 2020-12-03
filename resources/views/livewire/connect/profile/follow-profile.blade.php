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
    <a href="/profile/{{ $profile->profileable->data_slug('name') }}/{{ $profile->id }}/follow">
        <x-jet-button wire:click="follow" class="bg-blue-800 rounded">
            <i class="fas fa-plus"></i> &nbsp; {{ __('follow') }}
        </x-jet-button>
    </a>
    @endguest
    @endif
    @endcannot

    @can('update', $profile)
    <a href="/user/profile/edit">
        <x-jet-button wire:click="follow" class="bg-blue-800 rounded">
            {{ __('edit profile') }} &nbsp; <i class="fas fa-user-edit"></i>
        </x-jet-button>
    </a>
    @endcan
</div>
