<div x-data="profile_post_data()" x-init="loadMore()">
    <div wire:loading class="w-full">
        <x-loader_2 />
    </div>

    <div class="grid grid-cols-1 gap-3 md:gap-4">
        @forelse($posts as $post)
        <div>
            @include('includes.feed-display-cards.post-display', ['model' => $post])
        </div>
        @empty
        <div>
            <div>
                <div class="flex items-center justify-center p-3">
                    <i style="font-size: 4rem;" class="text-blue-700 fas fa-pencil-alt">
                    </i>
                </div>
                <div class="px-3 pb-3 text-lg font-medium text-center text-blue-700">
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
        <div class="w-full" wire:loading wire:target="loadMore">
            <x-loader_2 />
        </div>
    </div>
    <script>
        function profile_post_data() {
            return {
                loadMore: function() {
                    window.onscroll = function(ev) {
                        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                            if (parseInt('{{ $this->posts_count() }}', 10) > @this.perPage) {
                                @this.call('loadMore');
                            }
                        }
                    }
                }
            }
        }
    </script>
</div>