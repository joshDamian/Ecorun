<div x-data="{ shared: false, timeout: null }"
    x-init="Livewire.on('newShare.{{ $post->id }}', () => { clearTimeout(timeout); shared = true; timeout = setTimeout(() => { shared = false }, 2000);  })">
    <div
        class="px-3 py-4 border-t  @if($feedbackReady) border-b @endif border-gray-200 grid grid-cols-3 gap-3 sm:gap-4 sm:px-5 sm:py-3 sm:p-0">
        <div x-data="{ liked: '{{ $this->liked() }}', clicked: null }" class="px-2 py-1 bg-white rounded-full">
            <div class="flex items-center justify-center">
                <div class="flex items-center justify-center justify-items-center">
                    <i @click=" liked = (liked === '1') ? null : '1';"
                        :class="(liked === '1') ? 'text-red-700 fas' : 'text-blue-700 far'" wire:click="like"
                        class="text-xl fa-heart md:cursor-pointer"></i>
                </div>
                @php
                $likes_count = $this->likes();
                @endphp
                @if($likes_count > 0)
                <div class="ml-2 text-gray-700 text-md">
                    {{ $likes_count }}
                </div>
                @endif
            </div>
        </div>

        <a class="flex items-center justify-center px-2 py-1 bg-white rounded-full cursor-pointer" @if($view
            !=='post.show' ) href="{{ route('post.show', ['post' => $post->id]) }}" @else wire:click="toogleFeedback"
            @endif>
            <i class="text-xl text-blue-700 cursor-pointer far fa-comment"></i>
        </a>

        <div class="flex items-center justify-center px-2 py-1 bg-white rounded-full">
            <i wire:click="share" class="text-xl text-blue-700 cursor-pointer fas fa-share-alt"></i>
            @php
            $shares_count = $this->shares();
            @endphp
            @if($shares_count > 0)
            <div class="ml-2 text-gray-700 text-md">
                {{ $shares_count }}
            </div>
            @endif
        </div>
    </div>

    <div x-show.transition.opacity.out.duration.1500ms="shared"
        class="px-3 py-1 font-bold text-center text-white bg-blue-800 text-md">
        you shared this post on your timeline &nbsp; <i class="text-white fas fa-check"></i>
    </div>

    <div>
        @if($view === 'post.show')
        <div>
            @if($feedbackReady)
            <div>
                <div class="p-3 sm:px-5 sm:pt-1 sm:pb-3 sm:p-0">
                    <x-connect.comment.display-comments :comments="$post->loadMissing('comments')->comments" />
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
