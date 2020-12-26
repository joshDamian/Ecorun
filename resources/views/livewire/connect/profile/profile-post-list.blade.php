<div>
    <div wire:loading class="w-full">
        <x-loader_2 />
    </div>

    <div class="grid grid-cols-1 gap-3 scrolling-pagination md:gap-4">
        @forelse($posts as $post)
        <div>
            <x-connect.post.display-post :post="$post->loadMissing('gallery')" />
            <div class="bg-gray-100 border-t border-gray-200">
                @auth
                <div>
                    @livewire('connect.post.post-feedback', ['post' => $post, 'view' => 'post.index'], key(time()."post_fb_{$post->id}"))
                </div>
                @endauth
            </div>
        </div>

        @empty
        <div>
            <div class="bg-white">
                <div class="flex items-center justify-center p-3">
                    <i style="font-size: 6rem;" class="text-blue-700 fas fa-pencil-alt">
                    </i>
                </div>
                <div class="px-3 pb-3 text-lg font-medium text-center text-blue-700 bg-white">
                    <div>
                        @can('update', $this->profile)
                        make your first post
                        @endcan
                    </div>
                    <div>
                        @cannot('update', $this->profile)
                        {{ $this->profile->name }} has no posts.
                        @endcannot
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        window.onscroll = function() {
            if ((window.innerHeight + window.scrollY + 20) >= document.body.offsetHeight) {
                //Livewire.emit('loadOlderPosts', '{{ $posts->count() }}');
            }
        };
    });

</script>
@endpush
