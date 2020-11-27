<div wire:poll class="p-2 border-t border-gray-200 grid grid-cols-3 gap-2 sm:gap-4 sm:px-5 sm:py-3 sm:p-0">

    <div class="bg-gray-200 p-2 flex justify-center items-center rounded-full">
        <div x-data="{ liked: '{{ $this->liked() }}' }" class="text-xl">
            <i @click=" (liked === '1') ? liked = null : liked = '1' " :class="(liked === '1') ? 'text-red-700' : 'text-blue-700'" wire:click="like({{ $this->post->id }})" class="fas fa-heart md:cursor-pointer"></i>
            <span class="text-gray-700 text-md ">
                {{ $like_count > 0 ? $like_count : __('') }}
            </span>
        </div>
    </div>

    <div class="bg-gray-200 p-2 flex justify-center items-center rounded-full">
        <div>
            <i wire:click="displayComments" class="fas fa-comment text-xl cursor-pointer text-blue-700"></i>
        </div>
    </div>

    <div class="bg-gray-200 flex items-center justify-center p-2 rounded-full">
        <i class="fas fa-share-square cursor-pointer text-xl text-blue-700"></i>
    </div>
</div>
