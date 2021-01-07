<div>
    <div class="sticky flex mb-3 top-32">
        <x-jet-secondary-button class="mr-2" wire:click="setSortBy('{{ __('all') }}')">
            {{ __('all') }}
        </x-jet-secondary-button>

        @foreach($feed_types as $key => $card)
        <x-jet-secondary-button class="mr-2" wire:click="setSortBy('{{ $card['name'] }}')">
            {{ $card['name'] }}
        </x-jet-secondary-button>
        @endforeach
    </div>

    <div class="w-full" wire:loading wire:target="setSortBy">
        <x-loader_2 />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:gap-4">
        @forelse($this->displaying_feed as $key => $feed_item)
        @include($this->viewIncludeFolder . $this->feed_types[get_class($feed_item)]['view'], ['model' =>
        $feed_item])
        @empty
        @endforelse
    </div>
</div>
