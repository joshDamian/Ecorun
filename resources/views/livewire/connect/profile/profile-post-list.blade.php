<div>
    <div wire:loading class="w-full">
        <x-loader_2 />
    </div>

    <div class="grid grid-cols-1 gap-3 scrolling-pagination md:gap-4">
        @forelse($posts as $post)
        @if($post instanceof App\Models\Product)
        <div>
            <div class="flex justify-between px-3 py-3 bg-gray-100 border-b border-gray-200 sm:px-5 sm:py-3 sm:p-0">
                <div class="flex items-center flex-1">
                    <a class="mr-3" href="{{ route('profile.visit', ['profile' => $post->business->profile->tag]) }}">
                        <div style="background-image: url('{{ $post->business->profile->profile_photo_url }}'); background-size: cover; background-position: center center;" class="w-12 h-12 border-t-2 border-b-2 border-blue-700 rounded-full">
                        </div>
                    </a>

                    <div>
                        <a href="{{ route('profile.visit', ['profile' => $post->business->profile->tag]) }}">
                            <span class="font-medium text-blue-700 text-md">{{ $post->business->profile->name }}</span>
                        </a>

                        <div class="flex items-center">
                            <a class="flex-1 mr-2 truncate" href="{{ route('profile.visit', ['profile' => $post->business->profile->tag]) }}">
                                <span class="text-sm font-normal text-blue-600 truncate">{{ $post->business->profile->full_tag() }}</span>
                            </a>

                            <div class="text-sm font-normal text-gray-500">
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap justify-between px-3 py-3 text-xl font-bold bg-gray-100 border-b border-gray-200 sm:px-5 sm:py-3 sm:p-0">
                <div class="mr-3 text-blue-800">
                    {{ $post->name }}
                </div>
                <div class="text-blue-600">
                    {!! $post->price() !!}
                </div>
            </div>

            <div class="flex items-center justify-center p-3 bg-gray-100 border-b border-gray-200 justify-items-center">
                <img class="h-64" src="/storage/{{ $post->displayImage() }}" />
            </div>
            <div class="flex items-center justify-end px-3 py-3 text-right bg-gray-100 sm:px-5 sm:py-3 sm:p-0">
                <div class="mr-3">
                    @livewire('buy.cart.add-to-cart', ['productId' => $post->id])
                </div>

                <x-jet-button class="bg-blue-700">
                    shop
                </x-jet-button>
            </div>
        </div>
        @continue
        @endif
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
