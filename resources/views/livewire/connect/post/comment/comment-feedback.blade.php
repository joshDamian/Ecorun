<div>
    @include('includes.micro-views.comment-footer')
    <div>
        @if($view === 'comment.show')
        <div x-data x-init="Echo.channel('commentChannel.{{$comment->id}}').listen('RepliedToComment', (e) => {
            $wire.call('$refresh');
            })">
            @if($feedbackReady)
            <div>
                <div class="border-t py-2 mt-3 border-gray-300">
                    replies
                </div>

                <div class="p-3 mb-3 border border-gray-300 sm:px-5 sm:pt-1 sm:pb-3 sm:p-0">
                    <x-connect.comment.display-comments :comments="$comment->loadMissing('replies')->replies->take($this->feedbacksPerPage)" />
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>