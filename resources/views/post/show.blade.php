<x-app-layout>
    <div class="grid grid-cols-1 md:mb-3 md:grid-cols-3">
        <div class="md:col-span-2">
            <x-connect.post.display-post :post="$post" />
            <div class="bg-gray-100">
                @auth
                @livewire('connect.post.post-feedback', ['postId' => $post->id, 'view' => 'post.show'], key(md5('post_actions'.$post->id)))
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>