@props(['comments'])
<div x-data x-init="Livewire.on('newFeedback', () => {
    Livewire.hook('message.processed', function(mess, comp) {
    window.scrollTo(0, document.body.scrollHeight);
    })
    })">
    @forelse($comments as $key => $comment)
    @php
    $profile = $comment->profile;
    $profile_visit_url = $profile->url->visit;
    @endphp
    <div class="@if(!$loop->last) mb-2 md:mb-4 @endif">
        <div class="flex">
            <div class="mr-2 sm:mr-4">
                <a hrf="{{ $profile_visit_url }}">
                    <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                        class="w-10 h-10 border-t-2 border-b-2 border-blue-700 rounded-full">
                    </div>
                </a>
            </div>

            <div class="flex-shrink">
                <div style="border-radius: 1rem;" class="bg-gray-200 p-3">
                    <div class="flex self-stretch items-baseline">
                        <a href="{{ $profile_visit_url }}" class="text-xs flex-shrink flex-1 text-blue-700 font-bold">
                            {{ $profile->name }} &nbsp;<span class="text-gray-600">{{ $profile->full_tag() }}</span>
                        </a>
                    </div>
                    <x-display-text-content :content="$comment->safe_html" />
                </div>
                <div class="flex mt-1">
                    <p>
                        {{ $comment->created_at->diffForHumans(null, null, true) }}
                    </p>
                </div>
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
</div>