<x-social-layout>
    <div class="md:mb-3">
        <div class="grid grid-cols-1 gap-3 mb-3 sm:gap-4">
            <div class="px-3 py-3 bg-gray-200 shadow sm:px-5 sm:py-3">
                <div class="flex">
                    <div class="mr-3 text-lg font-bold text-blue-700">
                        {{ $post->profile->full_tag() }}'s <span class="text-gray-800">post.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 border-t border-gray-200">
            @livewire('connect.post.post-feedback', ['post' => $post, 'view' => 'post.show'])
        </div>
    </div>
</x-social-layout>
