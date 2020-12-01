<div wire:poll class="">
    <div class="p-2 border-t  @if($commentsReady) border-b @endif border-gray-200 grid grid-cols-3 gap-2 sm:gap-4 sm:px-5 sm:py-3 sm:p-0">
        <div x-data="{ liked: '{{ $this->liked() }}', clicked: null }" :class="{ 'border border-red-700': liked, 'animate__animated animate__bounce': clicked }" class="flex items-center justify-center p-2 bg-gray-200 rounded-full">
            <div class="text-xl">
                <i @click=" liked = (liked === '1') ? null : '1';" :class="(liked === '1') ? 'text-red-700' : 'text-blue-700'" wire:click="like" class="fas fa-heart md:cursor-pointer"></i>

                <span class="ml-2 text-gray-700 animate__animated animate__bounce text-md">
                    {{ $likes_count > 0 ? $likes_count : __('') }}
                </span>
            </div>
        </div>

        <div class="flex items-center justify-center p-2 bg-gray-200 rounded-full">
            <div>
                <i wire:click="displayComments" class="text-xl text-blue-700 cursor-pointer fas fa-comment"></i>
            </div>
        </div>

        <div class="flex items-center justify-center p-2 bg-gray-200 rounded-full">
            <i class="text-xl text-blue-700 cursor-pointer fas fa-share-alt"></i>
        </div>
    </div>

    <div>
        @if($commentsReady)
        @livewire('connect.post.comment.create-new-comment', ['post' => $this->post, 'profile' => $profile])
        <div class="p-2 sm:px-5 sm:pt-1 sm:pb-3 sm:p-0">
            <x-connect.comment.display-comments :comments="$this->post->comments" />
        </div>
        @endif
    </div>
</div>
