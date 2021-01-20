<div wire:init="initialize">
    <div class="flex items-center justify-between">
        <x-jet-input wire:model="query" placeholder="search for people, products, businesses"
            class="w-full mr-3 placeholder-blue-700 rounded-full" />
        <x-jet-button wire:click="$refresh" class="bg-blue-700">
            <i class="fas fa-search"></i>
        </x-jet-button>
    </div>

    <div class="flex items-start mt-3">
        <div class="flex-shrink-0 mr-3 text-xl font-bold text-blue-700">search in:</div>
        <select class="form-select" wire:model="data_set"> search in
            <option value="all">all</option>
            <option value="posts">posts</option>
            <option value="products">products</option>
            <option value="profiles">people</option>
            <option value="hashtags">hashtags</option>
        </select>
    </div>

    <div wire:loading class="w-full">
        <x-loader_2 />
    </div>

    <div class="mt-3">
        @forelse($this->results as $key => $result)
        @continue($result instanceof App\Models\Profile)
        @include($this->view_for_search_models[get_class($result)], ['model' =>
        $result])
        @empty
        @if($display && !empty(trim($this->query)))
        <div class="text-blue-700">
            <div class="font-semibold text-center">
                <div class="flex items-center justify-center p-4">
                    <i style="font-size: 5rem;" class="fas fa-search"></i>
                </div>
                not enough content here.
            </div>
        </div>
        @else
        <div class="text-blue-700">
            <div class="font-semibold text-center">
                <div class="flex items-center justify-center p-4">
                    <i style="font-size: 5rem;" class="fas fa-search"></i>
                </div>
                search for something.
            </div>
        </div>
        @endif
        @endforelse
    </div>
</div>
