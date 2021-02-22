<div x-data="{ show_options: false }">
    @php
    $post = $model;
    $gallery = $post->gallery;
    $profile = $post->profile;
    $profile_visit_url = $profile->url->visit;
    $image_count = $post->gallery_count ?? $gallery->count();
    if(!isset($view)) {
    $view = 'not-feed.list';
    }
    @endphp
    @if($view === 'feed.list' && (!$post->profile->followers->contains(auth()->user()->currentProfile)))
    @cannot('update', $post->profile)
    <div class="px-3 py-2 sm:px-5 bg-white font-semibold text-lg text-gray-600">
        Suggested content
    </div>
    @endcannot
    @endif
    <div class="bg-gray-100">
        <div class="flex justify-between px-3 py-3 border-b border-gray-200 sm:px-5 sm:py-3">
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
            @auth
            <div>
                <x-jet-secondary-button x-on:click="show_options = !show_options ">
                    <i
                        class="text-lg text-blue-700 cursor-pointer hover:text-black focus:text-black fas fa-ellipsis-v"></i>
                </x-jet-secondary-button>
            </div>
            @endauth
        </div>

        <div x-show.transition="show_options">
            <div>
                @php
                $post_option_key = "post_options_" . random_int(56, 667386514356) . $post->id . microtime();
                @endphp
                <div>
                    @livewire('connect.post.post-options', ['post' => $post], key($post_option_key))
                </div>
            </div>
        </div>

        <div>
            @if($post->content)
            <x-collapsible-text-content clamp="8" :encode="false" class="px-3 py-3 sm:px-5"
                :content="$post->safe_html" />
            @endif
        </div>

        <div>
            @if($image_count > 0 && $image_count > 1)
            <div>
                <x-connect.image.gallery view="list" height="h-48" :gallery="$gallery" />
            </div>
            @elseif($image_count > 0 && $image_count === 1)
            <div class="bg-gray-100">
                <img class="w-full" src="/storage/{{ $gallery->first()->image_url }}" />
            </div>
            @endif
        </div>
    </div>

    <div class="bg-gray-100 border-t border-gray-200">
        @auth
        @php $key = mt_rand(16, 5435778633678)."post_fb_{$post->id}"; @endphp
        <div>
            @livewire('connect.post.post-feedback', ['post' => $post, 'view' => 'post.index'],
            key($key))
        </div>
        @endauth
    </div>
</div>