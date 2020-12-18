<x-social-layout>
    <div class="md:mb-3">
        <div>
            <x-connect.post.display-post :post="$post" />
            <div class="bg-gray-100">
                @auth
                @livewire('connect.post.post-feedback', ['postId' => $post->id, 'view' => 'post.show'], key(md5('post_actions'.$post->id)))
                @endauth
            </div>
        </div>
    </div>
</x-social-layout>
