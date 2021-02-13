@props(['comment'])
<div {{ $attributes->
    merge(['class' => 'flex text-xs items-center']) }}>
    <div x-data="{ liked: '{{ $this->liked() }}', clicked: null }"
        class="mr-2">
        <div class="flex items-center justify-center justify-items-center">
            <i @click=" liked = (liked === '1') ? null : '1';"
                :class="(liked === '1') ? 'text-red-700 fas' : 'text-blue-700 far'" wire:click="like"
                class="text-xl fa-heart md:cursor-pointer"></i>
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
        @if($view !=='comment.show' ) href="{{ $comment->url->show }}" @else
        wire:click="toogleFeedback" @endif>
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

    <p class="mr-2">
        {{ $comment->created_at->diffForHumans(null, null, true) }}
    </p>
    @can('update', [$comment, auth()->user()->currentProfile])
    <a class="mr-2" href="{{ $comment->url->edit }}">
        <i class="text-gray-600 fas fa-edit"></i>
    </a>

    <a class="mr-2" href="{{ $comment->url->delete }}">
        <i class="text-gray-600 fas fa-trash"></i>
    </a>
    @endcan

    @if(!request()->routeIs('comment.show'))
    <a class="" href="{{ $comment->url->show }}">
        <i class="fas text-blue-700 fa-expand"></i>
    </a>
    @endif
</div>