<x-social-layout>
    @php
    $post_owner = $post->profile;
    $comment_profile = $comment->profile;
    $gallery = $comment->gallery;
    $gallery_count = $gallery->count();
    $feedback_key = $feedback_key = 'comment_feedback_for' . $comment->id . random_int(200, 80076554467);
    @endphp
    <div class="sticky z-40 px-3 py-1 bg-gray-100 bg-opacity-75 border-b border-gray-200 top-11 sm:px-5">
        <div class="flex">
            <a class="mr-4" href="{{ $comment->feedbackable->url->show }}?active_comment={{ $comment->id }}">
                <div class="text-xl text-blue-700">
                    <i class="fas fa-chevron-left"></i>
                </div>
            </a>
            <div class="flex-1 text-lg font-bold text-center text-blue-700">
                {{ $comment_profile->full_tag() }}'s <span class="text-gray-700">comment.</span>
            </div>
        </div>
    </div>

    <div>
        @include('includes.feed-display-cards.post-display', ['model' => $post])
    </div>

    <div class="flex">
        <a class="flex items-center flex-1 px-3 py-2 bg-white border-b border-gray-200"
            href="{{ $comment_profile->url->visit }}">
            <div style="background-image: url('{{ $comment_profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                class="w-10 h-10 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
            </div>
            <div class="grid grid-cols-1">
                <div class="font-semibold text-blue-700">
                    {{ $comment_profile->name }}
                </div>

                <div class="font-semibold text-blue-700">
                    {{ $comment_profile->full_tag() }}
                </div>
            </div>
        </a>
    </div>

    <div class="px-3 py-2 text-sm font-semibold text-gray-700 border-t border-b border-gray-200r">
        replying to <a class="underline text-blue-500" href="{{ $post_owner->url->visit }}">{{ $post_owner->full_tag() }}</a>
    </div>

    @if($comment->content)
    <x-display-text-content class="p-3 text-lg bg-white" :content="$comment->safe_html" />
    @endif

    <div>
        @if($gallery_count > 0 && $gallery_count === 1)
        <div wire:ignore class="bg-gray-100 p-3">
            <img class="w-full" src="/storage/{{ $gallery->first()->image_url }}" />
        </div>
        @elseif($gallery_count > 0 && $gallery_count > 1)
        <x-connect.image.gallery height="h-32 md:h-28" :gallery="$gallery" />
        @endif
    </div>

    <div class="mx-3">
        @livewire('connect.post.comment.comment-feedback', ['comment' => $comment, 'view' => 'comment.show'], key($feedback_key))
    </div>

    <div class="box-content sticky bottom-0 px-3 py-2 bg-gray-100 border-t border-gray-300">
        @livewire('connect.post.comment.reply.create-new-reply', ['comment' => $comment, 'profile' =>
        Auth::user()->currentProfile],
        key(time().$comment->id.'_reply'))
    </div>
</x-social-layout>