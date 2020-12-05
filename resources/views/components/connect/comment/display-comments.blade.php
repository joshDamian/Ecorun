@props(['comments'])
<div>
    @forelse($comments as $key => $comment)
    <div class="@if(!$loop->last) mb-2 md:mb-4 @endif">
        <div class="flex">
            <div class="mr-2 sm:mr-4">
                <div style="background-image: url('{{ $comment->profile->profile_image() }}'); background-size: cover; background-position: center center;" class="w-12 h-12 mr-3 border-blue-700 border-t-2 border-b-2 rounded-full">
                </div>
            </div>
            <div>
                <div style="border-radius: 1rem;" class="flex-1 p-3 bg-gray-200">
                    <h3 class="text-lg font-bold">{{ $comment->profile->name() }}</h3>
                    {{ $comment->content }}
                </div>
                <div class="flex mt-1">
                    <p>
                        {{ $comment->created_at->diffForHumans(null, true, true) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-blue-700">
        <div class="flex justify-center">
            <i style="font-size: 5rem;" class="fas fa-comments"></i>
        </div>
        <div class="text-center">
            be the first to comment.
        </div>
    </div>
    @endforelse
</div>