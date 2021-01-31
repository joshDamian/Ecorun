<x-social-layout>
    @php
    $gallery = $post->gallery;
    $profile = $post->profile;
    $profile_visit_url = $profile->url->visit;
    $image_count = $post->gallery_count ?? $gallery->count();
    @endphp
    <div class="md:mb-3">
        <div class="grid grid-cols-1 gap-0 sm:gap-2">
            <div class="sticky z-50 px-3 py-1 bg-gray-100 bg-opacity-75 top-12 sm:px-5">
                <div class="flex">
                    <a class="mr-4" href="{{ route('home') }}">
                        <div class="text-xl text-blue-700">
                            <i class="fas fa-chevron-left"></i>
                        </div>
                    </a>
                    <div class="flex-1 text-lg font-bold text-center text-blue-700">
                        {{ $profile->full_tag() }}'s <span class="text-gray-700">post.</span>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100">
                <div class="flex justify-between px-3 py-3 border-b border-gray-200 sm:px-5 sm:py-3 sm:p-0">
                    <div class="flex items-center flex-1">
                        <a class="mr-3" href="{{ $profile_visit_url }}">
                            <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                                class="w-12 h-12 border-t-2 border-b-2 border-blue-700 rounded-full">
                            </div>
                        </a>

                        <div>
                            <a href="{{ $profile_visit_url }}">
                                <span class="font-medium text-blue-700 text-md">{{ $profile->name }}</span>
                            </a>

                            <div class="flex items-center">
                                <a class="flex-1 mr-2 truncate" href="{{ $profile_visit_url }}">
                                    <span
                                        class="text-sm font-normal text-blue-600 truncate">{{ $profile->full_tag() }}</span>
                                </a>

                                <div class="text-sm font-normal text-gray-500">
                                    {{ $post->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($post->content)
                <x-display-text-content class="px-3 pt-3 rm-p-bottom-gap sm:px-5" :content="$post->safe_html" />
                @endif

                @if($image_count > 0)
                <div
                    class="bg-black">
                    @if($image_count > 1)
                    <div class="carousel" data-flickity='{ "lazyLoad": true }'>
                        @foreach($gallery as $key => $image)
                        <div class="flex items-center bg-gray-100 carousel-cell">
                            <img class="carousel-cell-image" data-flickity-lazyload="/storage/{{ $image->image_url }}"
                                alt="post image" />
                        </div>
                        @endforeach
                    </div>
                    @else
                    <img class="w-full" src="/storage/{{ $gallery->first()->image_url }}" />
                    @endif
                </div>
                @endif

                <div class="@if($image_count > 1) mt-8 @endif bg-gray-100 border-t border-gray-200">
                    @livewire('connect.post.post-feedback', ['post' => $post, 'view' => 'post.show'],
                    key(md5("post_feedback_for_{$post->id}_view_post.show")))
                </div>

                <div class="box-content sticky bottom-0 px-3 py-2 bg-gray-100 border-t border-gray-300">
                    @livewire('connect.post.comment.create-new-comment', ['post' => $post, 'profile' =>
                    Auth::user()->currentProfile],
                    key(time().$post->id.'_comment'))
                </div>
            </div>
        </div>
    </div>
</x-social-layout>
