<div x-data="{ bookmarked: ('{{$this->bookmarked}}' === '1') ? true : false }">
    <div wire:click="bookmark"
        class="px-3 py-2 font-semibold text-gray-600 bg-gray-100 cursor-pointer hover:bg-blue-200 focus:bg-blue-200 sm:px-5">
        <i :class="(bookmarked) ? 'fas fa-bookmark' : 'far fa-bookmark'" class="text-blue-700"></i>&nbsp; <span
            x-text="(bookmarked) ? 'Remove from bookmarks' : 'Bookmark'"></span>
    </div>
</div>