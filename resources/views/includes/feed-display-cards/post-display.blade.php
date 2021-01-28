<div>
    @php
    $post = $model;
    $gallery = $post->gallery;
    $profile = $post->profile;
    $profile_visit_url = $profile->url->visit;
    $image_count = $post->gallery_count ?? $gallery->count();
    @endphp
    <div class="bg-gray-100">
        <div class="flex justify-between px-3 py-3 border-b border-gray-200 sm:px-5 sm:py-3 sm:p-0">
            <div class="flex items-center flex-1">
                <a class="mr-3" href="{{ $profile_visit_url }}">
                    <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                        class="w-10 h-10 border-t-2 border-b-2 border-blue-700 rounded-full">
                    </div>
                </a>

                <div>
                    <a href="{{ $profile_visit_url }}">
                        <span class="font-medium text-blue-700 text-md">{{ $profile->name }}</span>
                    </a>

                    <div class="flex items-center">
                        <a class="flex-1 mr-2 truncate" href="{{ $profile_visit_url }}">
                            <span class="text-sm font-normal text-blue-600 truncate">{{ $profile->full_tag() }}</span>
                        </a>

                        <div class="text-sm font-normal text-gray-500">
                            {{ $post->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <x-connect.post.post-options :post="$post" /> --}}
        </div>
        @if($post->content)
        <x-display-text-content class="px-3 pt-3 rm-p-bottom-gap sm:px-5" :content="$post->safe_html" />
        @endif

        @if($image_count > 0)
        <div class="bg-gray-100">
            <div class="main-carousel" data-flickity='{ "lazyLoad": true }'>
                @foreach($gallery as $key => $image)
                <div class="flex items-center bg-black carousel-post-feed">
                    <img class="carousel-cell-image" data-flickity-lazyload="/storage/{{ $image->image_url }}"
                    alt="post image" />
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    <div class="bg-gray-100 border-t border-gray-200">
        @auth
        <div>
            @livewire('connect.post.post-feedback', ['post' => $post, 'view' => 'post.index'],
            key(microtime()."post_fb_{$post->id}"))
        </div>
        @endauth
    </div>
</div>