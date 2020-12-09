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
    <a href="/@{{ $profile->tag }}/follow">
        <x-jet-button wire:click="follow" class="bg-blue-800 rounded">
            <i class="fas fa-plus"></i> &nbsp; {{ __('follow') }}
        </x-jet-button>
    </a>
    @endguest
    @endif
    @endcannot

    @can('update', $profile)
    <a href="{{ route('profile.edit', ['tag' => $profile->tag, 'user' => request()->user()->profile->data_slug('name')]) }}">
        <x-jet-button wire:click="follow" class="bg-blue-800 rounded">
            {{ __('edit profile') }} &nbsp; <i class="fas fa-user-edit"></i>
        </x-jet-button>
    </a>
    @endcan
</div>