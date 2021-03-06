<x-social-layout>
    <div class="sticky z-40 px-3 py-1 bg-gray-100 bg-opacity-75 border-b border-gray-200 top-12 sm:px-5">
        <div class="flex">
            <a class="mr-4" href="{{ $post->url->show }}">
                <div class="text-xl text-blue-700">
                    <i class="fas fa-chevron-left"></i>
                </div>
            </a>
            <div class="flex-1 text-lg font-bold text-center text-blue-700">
                <span class="text-gray-700">edit</span> {{ $post->profile->full_tag() }}'s <span
                    class="text-gray-700">post.</span>
            </div>
        </div>
    </div>

    <div class="px-3 bg-white bg-opacity-75 py-3">
        @livewire('connect.post.edit-post', ['post' => $post, 'profile' => Auth::user()->currentProfile, 'confirm' => $confirm_delete ?? null], key("edit_post" .
        $post->id))
    </div>
</x-social-layout>