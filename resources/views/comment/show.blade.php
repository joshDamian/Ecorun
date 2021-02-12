<x-social-layout>
    @php
    $post_owner = $post->profile;
    $comment_profile = $comment->profile;
    $gallery = $comment->gallery;
    $gallery_count = $gallery->count();
    $feedback_key = $feedback_key = 'comment_feedback_for' . $comment->id . random_int(200, 80076554467);
    @endphp
    <div class="sticky z-40 px-3 py-1 bg-gray-100 bg-opacity-75 border-b border-gray-200 top-12 sm:px-5">
        <div class="flex items-center">
            <div class="mr-4">
                <a href="{{ $post->url->show }}?active_comment={{ $comment->id }}">
                    <div class="text-xl text-blue-700">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                </a>
            </div>

            <div class="flex-1 truncate font-semibold text-gray-700 text-md">
                <span class="text-blue-700">{{ $comment_profile->full_tag() }}'s</span> comment on <span
                    class="text-blue-700">{{ $post_owner->full_tag() }}'s</span> post.
            </div>
        </div>
    </div>

    <div x-data="{ show_post: false }">
        <div x-on:click="show_post = ! show_post"
            class="flex items-center justify-between p-3 font-medium text-sm text-blue-700 bg-gray-200 border-b border-gray-200 cursor-pointer">
            <span>{{ $post_owner->full_tag() }}'s post.</span>
            <span><i :class="(show_post) ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas"></i></span>
        </div>

        <template x-if="show_post">
            @include('includes.feed-display-cards.post-display', ['model' => $post])
        </template>
    </div>

    <div class="">
        <div class="p-3 font-semibold text-blue-700 bg-white border-b border-gray-200">
            {{ $comment_profile->full_tag() }}'s comment.
        </div>
        <div class="flex items-center flex-1 p-3 bg-gray-50 border-b border-gray-200">
            <a href="{{ $comment_profile->url->visit }}">
                <div style="background-image: url('{{ $comment_profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                    class="w-10 h-10 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
                </div>
            </a>
            <div class="grid grid-cols-1">
                <a href="{{ $comment_profile->url->visit }}">
                    <div class="font-semibold text-blue-700">
                        {{ $comment_profile->name }}
                    </div>
                </a>

                <a href="{{ $comment_profile->url->visit }}">
                    <div class="font-semibold text-blue-700">
                        {{ $comment_profile->full_tag() }}
                    </div>
                </a>
            </div>
        </div>
    </div>


    <div class="p-3 text-sm font-semibold text-gray-700 border-b bg-white border-gray-100">
        replying to <a class="text-blue-500 underline"
            href="{{ $post_owner->url->visit }}">{{ $post_owner->full_tag() }}</a>
    </div>

    @if($comment->content)
    <x-display-text-content class="p-3 bg-white text-md" :content="$comment->safe_html" />
    @endif

    <div class="bg-white border-t border-gray-200">
        @if($gallery_count > 0 && $gallery_count === 1)
        <div wire:ignore class="p-3 bg-white">
            <img class="w-full" src="/storage/{{ $gallery->first()->image_url }}" />
        </div>
        @elseif($gallery_count > 0 && $gallery_count > 1)
        <x-connect.image.gallery height="h-32 md:h-28" :gallery="$gallery" />
        @endif
    </div>

    <div class="p-3 border-t border-gray-200 bg-gray-50">
        @livewire('connect.post.comment.comment-feedback', ['comment' => $comment, 'view' => 'comment.show'],
        key($feedback_key))
    </div>

    <div class="box-content sticky bottom-0 px-3 py-2 bg-gray-100 border-t border-gray-300">
        @livewire('connect.post.comment.reply.create-new-reply', ['comment' => $comment, 'profile' =>
        Auth::user()->currentProfile],
        key(time().$comment->id.'_reply'))
    </div>
</x-social-layout>