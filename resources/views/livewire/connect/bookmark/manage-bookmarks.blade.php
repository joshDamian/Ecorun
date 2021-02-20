<div>
    <div class="grid grid-cols-1 gap-2 px-2 py-2 bg-gray-200 md:px-0">
        @forelse($bookmarks as $key => $bookmark)
        <div>
            <div class="flex justify-between px-3 py-2 font-semibold bg-white border-b border-gray-300 sm:px-5">
                <div class="grid grid-cols-1 mr-3">
                    <div class="text-lg text-gray-700 truncate dont-break-out">
                        {{ $bookmark->title }}
                    </div>
                    <div class="text-sm text-gray-500">
                        added {{ $bookmark->created_at->diffForHumans() }}
                    </div>
                </div>

                <div class="">
                    <x-jet-danger-button wire:click="confirmDelete({{$bookmark->id}})">
                        <i class="text-sm fas fa-trash"></i>
                    </x-jet-danger-button>
                </div>
            </div>
            @if($bookmark->bookmarkable)
            @include($bookmark_types[get_class($bookmark->bookmarkable)], ['model' => $bookmark->bookmarkable])
            @else
            <div class="flex items-center justify-center">
                content not available.
            </div>
            @endif
        </div>
        @empty
        <div class="p-5 text-blue-700 bg-gray-100">
            <div class="flex items-center justify-center">
                <i style="font-size: 5rem;" class="text-blue-700 fas fa-star"></i>
            </div>

            <div class="mt-5 text-xl font-semibold text-center">
                no bookmarks yet.
            </div>
        </div>
        @endforelse
    </div>

    <div>
        <x-jet-confirmation-modal wire:model="confirm">
            <x-slot name="title">
                <div class="text-left">
                    {{ __('Delete Bookmark') }}
                </div>
            </x-slot>

            <x-slot name="content">
                <div class="text-left">
                    Deleting a bookmark removes it entirely from our database.
                </div>
            </x-slot>

            <x-slot name="footer">
                <div>
                    <x-jet-secondary-button wire:click="cancel" class="mr-4">
                        {{ __('cancel') }}
                    </x-jet-secondary-button>
                    <x-jet-danger-button wire:click="delete">
                        {{ __('Delete') }}
                    </x-jet-danger-button>
                </div>
            </x-slot>
        </x-jet-confirmation-modal>
    </div>

    <div class="mx-2 md:mx-0">
        <x-paginator :data="$bookmarks" />
    </div>
</div>
