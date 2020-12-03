<div wire:init="loadPosts" wire:poll.1000ms>
    <div class="grid grid-cols-1 gap-2 md:gap-4">
        @foreach($posts as $post)
        <div>
            <x-connect.post.display-post :post="$post" />
            <div class="bg-gray-100 border border-gray-300">
                @auth
                @livewire('connect.post.post-feedback', ['postId' => $post->id, 'view' => 'post.index'], key(md5('post_actions'.$post->id)))
                @endauth
            </div>
        </div>
        @endforeach
    </div>
    <div>
        <x-jet-dialog-modal wire:model="displayOptions">
            <x-slot name="title">
            </x-slot>

            <x-slot name="content">
                <div class="bg-white">

                </div>
            </x-slot>

            <x-slot name="footer">

            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>