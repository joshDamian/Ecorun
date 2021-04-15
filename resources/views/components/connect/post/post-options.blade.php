@props(['post'])
<div x-data="{ show_profiles: false, bookmarked: ('{{$this->bookmarked}}' === '1') ? true : false, follows: ('{{$this->follows}}' === '1') ? true : false, show_copy: false,
}" class="grid grid-cols-1 text-xs bg-gray-200 border-b border-gray-300">
    <div>
        <div x-on:click="show_profiles = !show_profiles"
            class="flex justify-between px-3 py-3 font-semibold text-gray-600 bg-gray-100 cursor-pointer hover:bg-blue-200 focus:bg-blue-200 sm:px-5">
            <div>
                <i class="text-red-600 fas fa-heart"></i>&nbsp; See who liked.
            </div>

            <div>
                <i :class="show_profiles ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas"></i>
            </div>
        </div>

        <template x-if="show_profiles">
            <div class="px-3 py-3 sm:px-5">
                <x-connect.post.profiles-that-liked :post="$post" />
            </div>
        </template>
    </div>

    <div wire:click="bookmark"
        class="px-3 py-3 font-semibold text-gray-600 bg-gray-100 cursor-pointer hover:bg-blue-200 focus:bg-blue-200 sm:px-5">
        <i :class="(bookmarked) ? 'fas fa-bookmark' : 'far fa-bookmark'" class="text-blue-700"></i>&nbsp; <span
            x-text="(bookmarked) ? 'Remove from bookmarks.' : 'Bookmark.'"></span>
    </div>

    @cannot('update', $post->profile)
    <div wire:click="follow"
        class="px-3 py-3 font-semibold text-gray-600 bg-gray-100 cursor-pointer hover:bg-blue-200 focus:bg-blue-200 sm:px-5">
        <i :class="(follows) ? 'fas fa-user-friends' : 'fas fa-user-plus'" class="text-blue-700"></i>&nbsp; <span
            x-text="(follows) ? 'Unfollow.' : 'Follow.'"></span>
    </div>
    @endcannot

    @can('update', [$post, Auth::user()->currentProfile ?? (new App\Models\User())->currentProfile])
    <a href="{{ $post->url->edit }}"
        class="px-3 py-3 font-semibold text-gray-600 bg-gray-100 hover:bg-blue-200 focus:bg-blue-200 sm:px-5">
        <i class="text-green-600 fas fa-edit"></i>&nbsp; Edit
    </a>

    <a href="{{ $post->url->delete }}"
        class="px-3 py-3 font-semibold text-gray-600 bg-gray-100 hover:bg-blue-200 focus:bg-blue-200 sm:px-5">
        <i class="text-red-800 fas fa-trash"></i>&nbsp; Delete
    </a>
    @endcan

    <a x-on:click="show_copy = !show_copy"
        class="px-3 py-3 font-semibold text-gray-600 bg-gray-100 cursor-pointer select-none focus:bg-blue-200 hover:bg-blue-200 sm:px-5">
        <i class="fas fa-copy"></i> copy post link
    </a>
    <x-jet-input x-show="show_copy" class="w-full rounded-none" value="{{ $post->url->show }}" />
</div>
