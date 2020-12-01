<div wire:init="loadPosts" wire:poll.1000ms>
    <div class="grid grid-cols-1 gap-2 md:gap-4">
        @foreach($posts as $post)
        <div>
            <x-connect.post.display-post :post="$post" />
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