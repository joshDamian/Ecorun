<div wire:poll.5000ms wire:init="loadPosts">
    <div wire:loading wire:target="loadPosts" class="w-full">
        <x-loader />
    </div>

    <div class="grid grid-cols-1 scrolling-pagination gap-3 md:gap-4">
        @forelse($posts as $post)
        <div>
            <x-connect.post.display-post :post="$post" />
            <div class="bg-gray-100 border-t border-gray-200">
                @auth
                @livewire('connect.post.post-feedback', ['postId' => $post->id, 'view' => 'post.index'], key(md5('post_actions'.$post->id)))
                @endauth
            </div>
        </div>

        @empty
        @if($readyToLoad)
        <div class="bg-white">
            <div class="flex justify-center items-center p-3">
                <i style="font-size: 6rem;" class="fas text-blue-700 fa-pencil-alt">
                </i>
            </div>
            <div class="text-center text-lg font-medium text-blue-700 bg-white px-3 pb-3">
                @can('update', $profile)
                make your first post
                @endcan
                @cannot('update', $profile)
                {{ $profile->name }} has no posts.
                @endcannot
            </div>
        </div>
        @endif
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        window.onscroll = function() {
            if ((window.innerHeight + window.scrollY + 20) >= document.body.offsetHeight) {
                Livewire.emit('loadOlderPosts');
            }
        };
    });
</script>
@endpush