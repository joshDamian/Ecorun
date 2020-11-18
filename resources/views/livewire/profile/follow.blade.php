<div>
    @cannot('update', $profile)
    @if($this->isFollowing())
    <x-jet-button wire:click="follow" class="bg-blue-800 rounded">
        {{ __('unfollow') }}
    </x-jet-button>
    @else
    <x-jet-button wire:click="follow" class="bg-blue-800 rounded">
        <i class="fas fa-plus"></i> &nbsp; {{ __('follow') }}
    </x-jet-button>
    @endif
    @endcannot

    @can('update', $profile)
    <a href="/user/profile">
        <x-jet-button wire:click="follow" class="bg-blue-800 rounded">
            {{ __('edit profile') }} &nbsp; <i class="fas fa-user-edit"></i>
        </x-jet-button>
    </a>
    @endcan
</div>
