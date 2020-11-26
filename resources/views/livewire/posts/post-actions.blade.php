<div wire:poll.1000ms class="p-2 border-t border-gray-200 grid grid-cols-3 gap-2 sm:gap-4 sm:px-5 sm:py-3 sm:p-0">

    <div class="bg-gray-200 p-2 flex justify-center items-center rounded-full">
        <div class="text-xl">
            <i wire:click="like({{ $post->id }})" :class="{{ $liked }} ? 'text-red-700' : 'text-blue-700'" class="fas fa-heart md:cursor-pointer @if($liked) text-red-700 @else text-blue-700 @endif"></i>
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
