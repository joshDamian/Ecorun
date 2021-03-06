<div x-data="{ shared: false, timeout: null, event: 'newShare.{{ $feedback_id . '.' . str_replace('\\', '.', get_class($post)) }}' }"
    x-init=" () => { Livewire.on(event, () => { clearTimeout(timeout); shared = true; timeout = setTimeout(() => { shared = false }, 2000);  }) }">

    <div
        class="px-3 py-4 border-t @if($feedbackReady) border-b @endif border-gray-200 flex justify-between items-center sm:px-5 sm:py-3">
        <div x-data="{ liked: '{{ $this->liked() }}', clicked: null }"
            class="flex-grow px-2 py-2 mr-3 bg-white rounded-full">
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
                <div class="ml-2 font-bold text-gray-700 text-md">
                    {{ $likes_count }}
                </div>
                @endif
            </div>
        </div>

        <a class="flex items-center justify-center flex-grow px-2 py-2 mr-3 bg-white rounded-full cursor-pointer"
            @if($view !=='post.show' ) href="{{ $post->url->show }}" @else wire:click="toogleFeedback" @endif>
            <i class="text-xl text-blue-700 cursor-pointer far fa-comment"></i>
            @php
            $feedback_count = $this->feedbacks();
            @endphp
            @if($feedback_count > 0)
            <div class="ml-2 font-bold text-gray-700 text-md">
                {{ $feedback_count }}
            </div>
            @endif
        </a>

        <div class="flex items-center justify-center flex-grow px-2 py-2 bg-white rounded-full">
            <i wire:click="share" class="text-xl text-blue-700 cursor-pointer fas fa-share-alt"></i>
            @php
            $shares_count = $this->shares();
            @endphp
            @if($shares_count > 0)
            <div class="ml-2 font-bold text-gray-700 text-md">
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
        <div x-data x-init="Echo.channel('postChannel.{{$post->id}}').listen('CommentedOnPost', (e) => {
            $wire.call('$refresh');
            })">
            @if($feedbackReady)
            <div>
                <div class="p-3 sm:px-5 sm:pt-1 sm:pb-3 sm:p-0">
                    <x-connect.comment.display-comments
                        :comments="$post->loadMissing('comments')->comments->sortByDesc('created_at')->take($this->feedbacksPerPage)->reverse()" />
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>