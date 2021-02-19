<x-social-layout>
    <div class="sticky text-blue-700 font-bold top-12 bg-white px-3 py-2">
        Your bookmarks.
    </div>

    <div>
        @livewire('connect.bookmark.manage-bookmarks', key("manage_bookmarks"))
    </div>
</x-social-layout>