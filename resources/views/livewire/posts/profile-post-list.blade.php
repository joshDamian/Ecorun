<div wire:init="loadPosts" wire:poll>
    <div class="grid grid-cols-1 gap-2 md:gap-4">
        @foreach($posts as $post)
        <div>
            <x-post.display-post :post="$post" />
        </div>
        @endforeach
    </div>
</div>
