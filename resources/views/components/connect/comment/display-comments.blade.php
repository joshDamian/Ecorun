@props(['comments'])
<div x-data x-init=" () => {
    Livewire.on('newFeedback', () => {
    Livewire.hook('message.processed', function(mess, comp) {
    window.scrollTo(0, document.body.scrollHeight);
    })
    });
    @if(request()->input('active_comment'))
    history.scrollRestoration = 'manual';
    var reference = 'comment_{{request()->input('active_comment')}}';
    var comment_content = $refs[reference];
    if(comment_content) {
    window.addEventListener('DOMContentLoaded', () => {
    comment_content.classList.add('border-2');
    document.getElementById(reference).scrollIntoView();
    setTimeout(() => {
    comment_content.classList.remove('border-2');
    }, 2000);
    })
    }
    @endif
    }
    " class="pt-2">
    @forelse($comments as $key => $comment)
    @php
    $profile = $comment->profile;
    $profile_visit_url = $profile->url->visit;
    $gallery = $comment->gallery;
    $gallery_count = $gallery->count();
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
            <div class="w-8 mr-2 sm:mr-4">
            </div>
            <div>
                @if($comment->content)
                <div onclick="window.location = '{{ $comment->url->show }}'" x-ref="comment_{{$comment->id}}"
                    style="border-radius: 1rem;"
                    class="px-3 py-2 bg-gray-200 flex justify-center border-green-500 cursor-pointer focus:bg-blue-200 hover:bg-blue-200">
                    <x-display-text-content class="text-lg" :content="$comment->safe_html" />
                </div>
                @endif

                @if($gallery_count > 0)
                @if($gallery_count === 1)
                <div class="mt-1 w-44">
                    <x-connect.image.gallery height="h-28" view="list" curve="rounded-md" :gallery="$gallery" />
                </div>
                @else
                <div class="mt-1 w-52">
                    <x-connect.image.gallery height="h-24" view="list" curve="rounded-md" :gallery="$gallery" />
                </div>
                @endif
                @endif

                <x-connect.comment.comment-footer class="mt-1" :comment="$comment" />
            </div>
        </div>
    </div>
    @empty
    <div class="text-blue-700">
        <div class="flex justify-center">
            <i style="font-size: 3rem;" class="fas fa-comments"></i>
        </div>
        <div class="text-center">
            be the first to comment.
        </div>
    </div>
    @endforelse

    <div class="w-full mt-2" wire:loading>
        <x-loader_2 />
    </div>

    @if($this->feedbacks() > $comments->count())
    <div class="flex mt-2 justify-center">
        <x-jet-button x-on:click="$wire.feedbacksPerPage = $wire.feedbacksPerPage + 10" class="bg-blue-700">
            load more
        </x-jet-button>
    </div>
    @endif
</div>