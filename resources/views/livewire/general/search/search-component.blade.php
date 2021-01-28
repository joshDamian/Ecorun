<div wire:init="initialize">
    <div class="sticky p-3 bg-gray-200 bg-opacity-75 top-12">
        <div class="flex items-center justify-between">
            <x-jet-input wire:model="query" type="search" placeholder="search for people, products, businesses"
                class="w-full mr-3 placeholder-blue-700 rounded-full" />
            <x-jet-button wire:click="$refresh" class="bg-blue-700 rounded-full shadow">
                <i class="text-lg fas fa-search"></i>
            </x-jet-button>
        </div>

        <div class="flex items-baseline mt-3">
            <div class="flex-shrink-0 mr-3 text-lg font-bold text-blue-700">
                search in:
            </div>
            <select class="form-select" wire:model="data_set"> search in
                <option value="all">all</option>
                <option value="hashtags">hashtags</option>
                <option value="posts">posts</option>
                <option value="products">products</option>
                <option value="profiles">profiles</option>
            </select>
        </div>
    </div>

    <div wire:loading class="w-full">
        <x-loader_2 />
    </div>

    <div class="grid grid-cols-1 gap-3 p-3 md:mt-3 md:p-0">
        @forelse($this->results as $key => $result)
        @include($this->view_for_search_models[get_class($result)], ['model' =>
        $result])
        @empty
        @if($display && !empty(trim($this->query)))
        <div class="text-blue-700">
            <div class="font-semibold text-center">
                <div class="flex items-center justify-center p-4">
                    <i style="font-size: 5rem;" class="fas fa-search"></i>
                </div>
                no results for <span class="text-lg font-extrabold underline">{{ $query }}</span>, while searching in
                {{ $data_set }}
            </div>
        </div>
        @else
        <div class="text-blue-700">
            <div class="font-semibold text-center">
                <div class="flex items-center justify-center p-4">
                    <i style="font-size: 4.3rem;" class="fas fa-search"></i>
                </div>
                search for something.
            </div>
        </div>
        @endif
        @endforelse
    </div>
</div>
