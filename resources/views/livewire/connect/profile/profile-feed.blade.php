<div x-data="{
    show_button: false,
    loadMore: function() {
    window.onscroll = function(ev) {
    if ((window.innerHeight + Math.ceil(window.pageYOffset + 100)) >= document.body.offsetHeight) {
    if(parseInt('{{ $this->all_count() }}', 10) > @this.perPage) {
    @this.call('loadMore');
    }
    }
    };
    },
    collapsed: false
    }" x-init="() => { loadMore(); Echo.private('App.Models.Profile.{{$profile->id}}').listen('NewFeedContentForProfile', () => {
    show_button = true;
    });
    Livewire.on('toggled', (toggle) => { collapsed = toggle; });
    Livewire.on('newPost', () => { @this.call('setSortBy', 'all') });
    }">
    <div class="fixed bottom-0 z-20 flex w-full overflow-x-auto font-semibold bg-gray-100 bg-gray-200 border-t border-gray-300 md:z-30 md:bg-opacity-75 md:border-b md:sticky"
        :class="(collapsed) ? 'md:top-12' : 'md:top-28'">
        <div onclick="window.scrollTo(0, 0)" wire:click="setSortBy('{{ __('all') }}')"
            class="py-2 text-center select-none flex-shrink-0 flex-grow font-semibold cursor-pointer hover:text-blue-700 hover:bg-white px-3 @if($this->sortBy === 'all') bg-white text-blue-700 @else text-gray-700 @endif">
            {{ __('All') }}
        </div>

        @foreach($feed_types as $key => $card)
        <div onclick="window.scrollTo(0, 0)" wire:click="setSortBy('{{ $card['name'] }}')"
            class="py-2 select-none text-center flex-shrink-0 flex-grow font-semibold cursor-pointer hover:text-blue-700 hover:bg-white px-3 @if($this->sortBy === $card['name']) bg-white text-blue-700 @else text-gray-700 @endif">
            {{ ucwords($card['name']) }}
        </div>
        @endforeach

        <div onclick="window.scrollTo(0, 0)" wire:click="setSortBy('{{ __('photos') }}')"
            class="py-2 select-none text-center flex-grow flex-shrink-0 font-semibold cursor-pointer hover:text-blue-700 hover:bg-white px-3 @if($this->sortBy === 'photos') bg-white text-blue-700 @else text-gray-700 @endif">
            {{ __('Photos') }}
        </div>

        <div onclick="window.scrollTo(0, 0)" wire:click="setSortBy('{{ __('mentions') }}')"
            class="py-2 select-none text-center flex-shrink-0 flex-grow font-semibold cursor-pointer hover:text-blue-700 hover:bg-white px-3 @if($this->sortBy === 'mentions') bg-white text-blue-700 @else text-gray-700 @endif">
            {{ __('Mentions') }}
        </div>
    </div>

    <div x-show="show_button" class="sticky flex items-center justify-center p-2 top-16 md:top-40">
        <x-jet-button wire:click="$refresh" @click="window.scrollTo(0, 0); show_button = false"
            class="bg-blue-700 rounded-full">
            load new content &nbsp; <i class="fas animate-bounce fa-arrow-up"></i>
        </x-jet-button>
    </div>

    <div class="w-full" wire:loading wire:target="setSortBy, setDisplayReady">
        <x-loader_2 />
    </div>

    <div class="grid grid-cols-1 gap-3 pb-11 md:pb-0 sm:gap-4">
        @forelse($this->displaying_feed as $key => $feed_item)
        @include($this->viewIncludeFolder . $this->feed_types[get_class($feed_item)]['view'], ['model' =>
        $feed_item])
        @empty
        @if($display_ready)
        <div class="text-blue-700">
            <div class="font-semibold text-center">
                <div class="flex items-center justify-center p-4">
                    <i style="font-size: 5rem;" class="far fa-folder"></i>
                </div>
                not enough content here.
            </div>
        </div>
        @endif
        @endforelse
        <div class="w-full" wire:loading wire:target="loadMore">
            <x-loader_2 />
        </div>
    </div>
</div>