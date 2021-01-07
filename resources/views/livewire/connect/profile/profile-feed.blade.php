<div>
    <div
        class="fixed bottom-0 flex w-full overflow-x-auto font-semibold bg-gray-200 md:sticky md:bg-gray-100 md:bg-opacity-75 md:top-32">
        <div onclick="window.scrollTo(0, 0)" wire:click="setSortBy('{{ __('all') }}')"
            class="py-2 text-center flex-shrink-0 font-semibold flex-1 cursor-pointer hover:text-blue-700 hover:bg-white px-3 @if($this->sortBy === 'all') bg-white text-blue-700 @else text-gray-700 @endif">
            {{ __('All') }}
        </div>

        @foreach($feed_types as $key => $card)
        <div onclick="window.scrollTo(0, 0)" wire:click="setSortBy('{{ $card['name'] }}')"
            class="py-2 text-center flex-shrink-0 flex-1 font-semibold cursor-pointer hover:text-blue-700 hover:bg-white px-3 @if($this->sortBy === $card['name']) bg-white text-blue-700 @else text-gray-700 @endif">
            {{ ucwords($card['name']) }}
        </div>
        @endforeach

        <div onclick="window.scrollTo(0, 0)" wire:click="setSortBy('{{ __('photos') }}')"
            class="py-2 text-center flex-shrink-0 flex-1 font-semibold cursor-pointer hover:text-blue-700 hover:bg-white px-3 @if($this->sortBy === 'photos') bg-white text-blue-700 @else text-gray-700 @endif">
            {{ __('Photos') }}
        </div>
    </div>

    <div class="w-full" wire:loading wire:target="setSortBy">
        <x-loader_2 />
    </div>

    <div wire:loading.remove class="grid grid-cols-1 gap-3 pb-11 md:pb-0 sm:gap-4">
        @forelse($this->displaying_feed as $key => $feed_item)
        @include($this->viewIncludeFolder . $this->feed_types[get_class($feed_item)]['view'], ['model' =>
        $feed_item])
        @empty
        <div class="text-blue-700">
            @switch($this->sortBy)
            @case('all')
            <div class="flex items-center justify-center p-4">
                <i style="font-size: 6rem;" class="fas fa-home-user"></i>
            </div>
            <div class="text-center">
                your personal feed bank is empty.
            </div>
            @break
            @case('photos')
            <div class="flex items-center justify-center p-4">
                <i style="font-size: 6rem;" class="far fa-images"></i>
            </div>
            <div class="text-center">
                you don't have enough photo content.
            </div>
            @break
            @endswitch
        </div>
        @endforelse
    </div>
</div>
