<div x-data="{ show_options: false }">
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
            <div>
                <x-jet-secondary-button x-on:click="show_options = !show_options ">
                    <i
                        class="text-lg text-blue-700 cursor-pointer hover:text-black focus:text-black fas fa-ellipsis-v"></i>
                </x-jet-secondary-button>
            </div>
        </div>

        <div x-show.transition="show_options">
            <x-connect.post.post-options :post="$post" />
        </div>

        @if($post->content)
        <x-display-text-content :collapsible="true" class="px-3 py-3 sm:px-5" :content="$post->safe_html" />
        @endif

        @if($image_count > 0)
        @if($image_count > 1)
        <div wire:ignore id="gallery_{{ $post->id }}">
            <x-connect.image.carousel :gallery="$gallery" />
        </div>
        @else
        <div wire:ignore class="bg-gray-100">
            <img class="w-full" src="/storage/{{ $gallery->first()->image_url }}" />
        </div>
        @endif
        @endif
    </div>

    <div class="@if($image_count > 1) mt-8 @endif bg-gray-100 border-t border-gray-200">
        @auth
        @php $key = mt_rand(16, 5435778633678)."post_fb_{$post->id}"; @endphp
        <div>
            @livewire('connect.post.post-feedback', ['post' => $post, 'view' => 'post.index'],
            key($key))
        </div>
        @endauth
    </div>
</div>