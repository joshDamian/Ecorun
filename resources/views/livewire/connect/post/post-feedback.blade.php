<div wire:poll class="">
    <div class="px-3 py-4 border-t  @if($feedbackReady) border-b @endif border-gray-200 grid grid-cols-3 gap-3 sm:gap-4 sm:px-5 sm:py-3 sm:p-0">
        <div x-data="{ liked: '{{ $this->liked() }}', clicked: null }" :class="{ 'border-t-2 border-b-2 border-red-700': liked, 'animate__animated animate__bounce': clicked }" class="flex items-center justify-center px-2 py-1 bg-white rounded-full">
            <div class="text-xl">
                <i @click=" liked = (liked === '1') ? null : '1';" :class="(liked === '1') ? 'text-red-700' : 'text-blue-700'" wire:click="like" class="fas fa-heart md:cursor-pointer"></i>

                <span class="ml-2 text-gray-700 animate__animated animate__bounce text-md">
                    {{ $likes_count > 0 ? $likes_count : __('') }}
                </span>
            </div>
        </div>

        <div class="flex items-center justify-center px-2 py-1 bg-white rounded-full">
            <div>
                @if($view === 'post.show')
                <i wire:click="toogleFeedback" class="text-xl text-blue-700 cursor-pointer fas fa-comment"></i>
                @else
                <a href="{{ route('post.show', ['post' => $this->post->id]) }}">
                    <i class="text-xl text-blue-700 cursor-pointer fas fa-comment"></i>
                </a>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-center px-2 py-1 bg-white rounded-full">
            <i class="text-xl text-blue-700 cursor-pointer fas fa-share-alt"></i>
        </div>
    </div>

    <div>
        @if($feedbackReady)
        @livewire('connect.post.comment.create-new-comment', ['post' => $this->post, 'profile' => $profile])
        <div class="p-3 sm:px-5 sm:pt-1 sm:pb-3 sm:p-0">
            <x-connect.comment.display-comments :comments="$this->post->comments" />
        </div>
        @endif
    </div>
</div>