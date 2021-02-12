@props(['comments'])
<div x-data="{ activeComment: '{{ request()->input('active_comment') }}' }" x-init=" ()=> {
    Livewire.on('newFeedback', () => {
    Livewire.hook('message.processed', function(mess, comp) {
    window.scrollTo(0, document.body.scrollHeight);
    })
    });

    if(activeComment !== '') {
    history.scrollRestoration = 'manual';
    var reference = 'comment_' + activeComment;
    var comment_content = $refs[reference];
    if(comment_content) {
    window.addEventListener('DOMContentLoaded', () => {
    comment_content.classList.add('border-2');
    document.getElementById(reference).scrollIntoView();
    setTimeout(() => {
    comment_content.classList.remove('border-2');
    activeComment = '';
    }, 2000);
    })
    }
    }
    }
    " class="pt-2">
    <div class="w-full" wire:target="feedbacksPerPage" wire:loading>
        <x-loader_2 />
    </div>
    @if($this->feedbacks() > $comments->count())
    <div class="flex justify-center mb-2">
        <x-jet-button x-on:click="$wire.feedbacksPerPage = $wire.feedbacksPerPage + 10" class="bg-blue-700">
            load previous
        </x-jet-button>
    </div>
    @endif
    @forelse($comments as $key => $comment)
    @php
    $profile = $comment->profile;
    $profile_visit_url = $profile->url->visit;
    $gallery = $comment->gallery;
    $gallery_count = $gallery->count();
    $feedback_key = 'comment_feedback_for' . $comment->id . random_int(200, 80076554467);
    @endphp
    <div id="comment_{{$comment->id}}" class="@if(!$loop->last) mb-2 md:mb-4 @endif">
        <div class="flex items-center">
            <div class="mr-2 sm:mr-4">
                <a hrf="{{ $profile_visit_url }}">
                    <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                        class="w-8 h-8 border-t-2 border-b-2 border-blue-700 rounded-full">
                    </div>
                </a>
            </div>

            <div class="flex-shrink">
                <div class="flex items-baseline self-stretch">
                    <a href="{{ $profile_visit_url }}" class="flex-1 flex-shrink text-xs font-bold text-blue-700">
                        {{ $profile->name }} &nbsp;<span class="text-gray-700">{{ $profile->full_tag() }}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="flex">
            <div class="flex-shrink-0 w-8 mr-2 sm:mr-4">
            </div>

            <div class="flex-shrink">
                @if($comment->content)
                <div x-ref="comment_{{$comment->id}}" style="border-radius: 1rem;"
                    class="flex justify-center bg-gray-300 bg-opacity-75 border-green-400 cursor-pointer focus:bg-blue-200 hover:bg-blue-200">
                    <x-collapsible-text-content clamp="8" class="px-3 py-2 text-md dont-break-out"
                        :content="$comment->safe_html" />
                </div>
                @endif
            </div>
        </div>

        <div class="flex">
            <div class="flex-shrink-0 w-8 mr-2 sm:mr-4">
            </div>
            <div class="flex-shrink">
                @if($gallery_count > 0 && $gallery_count === 1)
                <div class="mt-1 w-44">
                    <x-connect.image.gallery height="h-28" view="list" curve="rounded-md" :gallery="$gallery" />
                </div>
                @elseif($gallery_count > 0 && $gallery_count > 1)
                <div class="mt-1 w-52">
                    <x-connect.image.gallery height="h-24" view="list" curve="rounded-md" :gallery="$gallery" />
                </div>
                @endif
            </div>
        </div>

        <div class="flex mt-2">
            <div class="w-8 mr-2 sm:mr-4">
            </div>
            <div>
                @livewire('connect.post.comment.comment-feedback', ['comment' => $comment, 'view' => 'comment.list'],
                key($feedback_key))
            </div>
        </div>
    </div>
    @empty
    <div class="text-blue-700">
        <div class="flex justify-center">
            <i style="font-size: 2rem;" class="fas fa-comments"></i>
        </div>
        <div class="text-center">
            be the first to @if(request()->routeIs('post.show')) comment. @else reply. @endif
        </div>
    </div>
    @endforelse
</div>