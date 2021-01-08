<div>
    <div
        class="px-3 py-4 border-t  @if($feedbackReady) border-b @endif border-gray-200 grid grid-cols-3 gap-3 sm:gap-4 sm:px-5 sm:py-3 sm:p-0">
        <div x-data="{ liked: '{{ $this->liked() }}', clicked: null }" class="px-2 py-1 bg-white rounded-full">
            <div class="flex items-center justify-center">
                <div class="flex items-center justify-center mr-2 justify-items-center">
                    <i @click=" liked = (liked === '1') ? null : '1';"
                        :class="(liked === '1') ? 'text-red-700 far' : 'text-blue-700 far'" wire:click="like"
                        class="text-xl fa-heart md:cursor-pointer"></i>
                </div>
                <div class="text-gray-700 animate__animated animate__bounce text-md">
                    {{ $likes_count > 0 ? $likes_count : '' }}
                </div>
            </div>
        </div>

        <a class="flex items-center justify-center cursor-pointer px-2 py-1 bg-white rounded-full" @if($view !=='post.show') href="{{ route('post.show', ['post' => $this->post->id]) }}" @else wire:click="toogleFeedback" @endif>
            <i class="text-xl text-blue-700 cursor-pointer far fa-comment"></i>
        </a>

        <div class="flex items-center justify-center px-2 py-1 bg-white rounded-full">
            <i class="text-xl text-blue-700 cursor-pointer fas fa-share-alt"></i>
        </div>
    </div>

    <div>
        @if($view === 'post.show')
        <div>
            @if($feedbackReady)
            <div>
                <div class="p-3 sm:px-5 sm:pt-1 sm:pb-3 sm:p-0">
                    <x-connect.comment.display-comments :comments="$this->post->loadMissing('comments')->comments" />
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>