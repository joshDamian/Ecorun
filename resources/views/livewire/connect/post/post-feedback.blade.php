<div wire:poll class="">
    <div class="p-2 border-t  @if($commentsReady) border-b @endif border-gray-200 grid grid-cols-3 gap-2 sm:gap-4 sm:px-5 sm:py-3 sm:p-0">
        <div x-data="{ liked: '{{ $this->liked() }}', clicked: null }" :class="{ 'border border-red-700': liked, 'animate__animated animate__bounce': clicked }" class="p-2 bg-gray-200 flex justify-center items-center rounded-full">
            <div class="text-xl">
                <i @click=" 
                    (liked === '1') ? liked = null : liked = '1';
                    $nextTick(() => { 
                        clicked = liked ? true : null;
                        clicked ? setTimeout(function() { clicked = null; }, 2000) : true;
                    });
                    " :class="(liked === '1') ? 'text-red-700' : 'text-blue-700'" wire:click="like" class="fas fa-heart md:cursor-pointer"></i>
                <span class="text-gray-700 animate__animated animate__bounce ml-2 text-md">
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
            <i class="fas fa-share-alt cursor-pointer text-xl text-blue-700"></i>
        </div>
    </div>

    <div>
        @if($commentsReady)
        @livewire('comment.create-new-comment', ['commentable' => $this->post, 'profile' => $user->profile])
        <div class="p-2 sm:px-5 sm:pt-1 sm:pb-3 sm:p-0">
            @forelse($this->post->comments as $key => $comment)
            <div class="@if(!$loop->last) mb-2 md:mb-4 @endif">
                <div class="flex">
                    <div class="mr-2 sm:mr-4">
                        <div style="background-image: url('{{ $comment->profile->profile_image() }}'); background-size: cover; background-position: center center;" class="w-12 rounded-full mr-3 h-12">
                        </div>
                    </div>
                    <div>
                        <div style="border-radius: 1rem;" class="bg-gray-200 flex-1 p-3">
                            <h3 class="text-lg font-bold">{{ $comment->profile->name() }}</h3>
                            {{ $comment->content }}
                        </div>
                        <div class="mt-1 flex">
                            <p>{{ $comment->created_at->diffForHumans(null, true, true) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-blue-700">
                <div class="flex justify-center">
                    <i style="font-size: 5rem;" class="fas fa-comments"></i>
                </div>
                <div class="text-center">
                    be the first to comment.
                </div>
            </div>
            @endforelse
        </div>
        @endif
    </div>
</div>
