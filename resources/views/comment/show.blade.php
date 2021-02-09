<x-social-layout>
    @php
    $post = $comment->feedbackable;
    $post_owner = $post->profile;
    $comment_profile = $comment->profile;
    @endphp
    <div class="sticky z-40 px-3 py-1 bg-gray-100 bg-opacity-75 border-b border-gray-200 top-11 sm:px-5">
        <div class="flex">
            <a class="mr-4" href="{{ $comment->feedbackable->url->show }}?active_comment={{ $comment->id }}">
                <div class="text-xl text-blue-700">
                    <i class="fas fa-chevron-left"></i>
                </div>
            </a>
            <div class="flex-1 text-lg font-bold text-center text-blue-700">
                {{ $comment_profile->full_tag() }}'s <span
                    class="text-gray-700">comment.</span>
            </div>
        </div>
    </div>

    <div>
        @include('includes.feed-display-cards.post-display', ['model' => $post])
    </div>

    <div class="flex">
        <a class="flex items-center flex-1 bg-white px-3 border-b border-gray-200 py-2" href="{{ $comment_profile->url->visit }}">
            <div style="background-image: url('{{ $comment_profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                class="w-10 mr-3 h-10 border-t-2 border-b-2 border-blue-700 rounded-full">
            </div>
            <div class="grid grid-cols-1">
                <div class="text-blue-700 font-semibold">
                    {{ $comment_profile->name }}
                </div>

                <div class="text-blue-700 font-semibold">
                    {{ $comment_profile->full_tag() }}
                </div>
            </div>
        </a>
    </div>

    <div class="px-3 py-2 text-gray-700 border-t border-b border-gray-200r font-semibold">
        replying to {{ $post_owner->full_tag() }}
    </div>

    @if($comment->content)
    <x-display-text-content class="p-3 bg-white" :content="$comment->safe_html" />
    @endif
</x-social-layout>