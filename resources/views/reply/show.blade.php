<x-social-layout>
    @php
    $post_owner = $post->profile;
    $comment_profile = $comment->profile;
    $comment_gallery = $comment->gallery;
    $comment_gallery_count = $comment_gallery->count();
    $reply_gallery = $reply->gallery;
    $reply_gallery_count = $reply_gallery->count();
    $reply_profile = $reply->profile;
    $comment_feedback_key = 'comment_feedback_for' . $comment->id . random_int(200, 80076554467);
    $reply_feedback_key = 'reply_feedback_for' . $reply->id . random_int(50000, 800754467);
    @endphp
    <div class="sticky z-40 px-3 py-1 bg-gray-100 bg-opacity-75 border-b border-gray-200 top-12 sm:px-5">
        <div class="flex items-center">
            <div class="mr-4">
                <a href="{{ $comment->url->show }}?active_comment={{ $reply->id }}">
                    <div class="text-xl text-blue-700">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                </a>
            </div>
            <div class="flex-1 text-sm font-medium text-gray-600 truncate">
                <span class="text-blue-700">{{ $reply_profile->full_tag() }}'s</span> reply to <span
                    class="text-blue-700">{{ $comment_profile->full_tag() }}'s</span> comment on <span
                    class="text-blue-700">{{ $post_owner->full_tag() }}'s</span> post.
            </div>
        </div>
    </div>

    <div x-data="{ show_post: false }">
        <div x-on:click="show_post = ! show_post"
            class="flex items-center justify-between p-3 text-sm font-medium text-gray-600 bg-gray-200 border-b border-gray-200 cursor-pointer">
            <span>{{ $post_owner->full_tag() }}'s post.</span>
            <span><i :class="(show_post) ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas"></i></span>
        </div>

        <template x-if="show_post">
            @include('includes.feed-display-cards.post-display', ['model' => $post])
        </template>
    </div>

    <div class="">
        <div class="p-3 text-sm font-medium text-gray-600 border-b border-gray-200 bg-gray-50">
            {{ $comment_profile->full_tag() }}'s comment.
        </div>

        <div class="flex items-center flex-1 p-3 bg-gray-100 border-b border-gray-200">
            <a href="{{ $comment_profile->url->visit }}">
                <div style="background-image: url('{{ $comment_profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                    class="w-10 h-10 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
                </div>
            </a>
            <div class="grid grid-cols-1">
                <a href="{{ $comment_profile->url->visit }}">
                    <div class="text-sm font-medium text-blue-700">
                        {{ $comment_profile->name }}
                    </div>
                </a>

                <a href="{{ $comment_profile->url->visit }}">
                    <div class="text-sm font-medium text-blue-700">
                        {{ $comment_profile->full_tag() }}
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="p-3 text-sm font-medium text-gray-500 border-b border-gray-200 bg-gray-50">
        replying to <a class="text-blue-500 underline"
            href="{{ $post_owner->url->visit }}">{{ $post_owner->full_tag() }}</a>
    </div>

    @if($comment->content)
    <x-display-text-content class="p-3 bg-gray-50 text-md" :content="$comment->safe_html" />
    @endif

    <div class="bg-gray-50">
        @if($comment_gallery_count > 0 && $comment_gallery_count === 1)
        <div wire:ignore class="p-3 border-t border-gray-100 bg-gray-50">
            <img class="w-full" src="/storage/{{ $comment_gallery->first()->image_url }}" />
        </div>
        @elseif($comment_gallery_count > 0 && $comment_gallery_count > 1)
        <div class="border-t border-gray-100">
            <x-connect.image.gallery height="h-32 md:h-28" :gallery="$comment_gallery" />
        </div>
        @endif
    </div>

    <div class="p-3 bg-gray-100 border-t border-gray-200">
        @livewire('connect.post.comment.comment-feedback', ['comment' => $comment, 'view' => 'comment.list'],
        key($comment_feedback_key))
    </div>

    <div class="mt-3 bg-white">
        <div class="p-3 font-semibold text-blue-700 bg-white border-b border-gray-200">
            {{ $reply_profile->full_tag() }}'s reply.
        </div>

        <div class="flex items-center flex-1 p-3 border-b border-gray-200 bg-gray-50">
            <a href="{{ $reply_profile->url->visit }}">
                <div style="background-image: url('{{ $reply_profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                    class="w-10 h-10 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
                </div>
            </a>
            <div class="grid grid-cols-1">
                <a href="{{ $reply_profile->url->visit }}">
                    <div class="font-semibold text-blue-700">
                        {{ $reply_profile->name }}
                    </div>
                </a>

                <a href="{{ $reply_profile->url->visit }}">
                    <div class="font-semibold text-blue-700">
                        {{ $reply_profile->full_tag() }}
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="p-3 text-sm font-semibold text-gray-700 bg-white border-b border-gray-100">
        replying to <a class="text-blue-500 underline"
            href="{{ $comment_profile->url->visit }}">{{ $comment_profile->full_tag() }}</a>
    </div>

    @if($reply->content)
    <x-display-text-content class="p-3 bg-white text-md" :content="$reply->safe_html" />
    @endif

    <div class="bg-white">
        @if($reply_gallery_count > 0 && $reply_gallery_count === 1)
        <div wire:ignore class="p-3 bg-white border-t border-gray-100">
            <img class="w-full" src="/storage/{{ $reply_gallery->first()->image_url }}" />
        </div>
        @elseif($reply_gallery_count > 0 && $reply_gallery_count > 1)
        <div class="border-t border-gray-100">
            <x-connect.image.gallery height="h-32 md:h-28" :gallery="$reply_gallery" />
        </div>
        @endif
    </div>

    <div class="p-3 border-t border-gray-100 bg-gray-50">
        @livewire('connect.post.comment.comment-feedback', ['comment' => $reply, 'view' => 'comment.list'],
        key($reply_feedback_key))
    </div>

</x-social-layout>
