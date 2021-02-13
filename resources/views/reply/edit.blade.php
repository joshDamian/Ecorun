<x-social-layout>
    <div class="sticky z-40 px-3 py-1 bg-gray-100 bg-opacity-75 border-b border-gray-200 top-12 sm:px-5">
        <div class="flex items-center overflow-x-auto">
            <div class="mr-4">
                <a href="{{ $reply->url->show }}">
                    <div class="text-xl text-blue-700">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                </a>
            </div>
            <div class="flex-1 text-lg font-bold text-center text-blue-700">
                <span class="text-gray-700">edit</span> {{ $reply->profile->full_tag() }}'s <span
                    class="text-gray-700">reply.</span>
            </div>
        </div>
    </div>

    <div class="px-3 py-3 bg-white bg-opacity-75">
        @livewire('connect.post.comment.reply.edit-reply', ['reply' => $reply, 'profile' =>
        Auth::user()->currentProfile, 'confirm' => $confirm_delete ?? null], key("edit_reply" .
        $reply->id))
    </div>
</x-social-layout>