@props(['post', 'image_count' => $post->gallery->count(), 'like_count' => $post->likes->count() ])
<div>
    <div class="bg-gray-100 sm:shadow">
        <div class="flex justify-between px-3 py-3 border-b border-gray-200 sm:px-5 sm:py-3 sm:p-0">
            <a class="block" href="{{ route('profile.visit', ['profile' => $post->profile->id, 'slug' => $post->profile->data_slug('name')]) }}">
                <div class="flex items-center">
                    <div style="background-image: url('{{ $post->profile->profile_photo_url }}'); background-size: cover; background-position: center center;" class="w-12 h-12 mr-3 border-t-2 border-b-2 border-blue-700 rounded-full">
                    </div>
                    <div>
                        <span class="font-medium text-blue-700 text-md">{{ $post->profile->name }}</span>
                        <div class="text-sm font-normal text-gray-500">
                            {{ $post->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </a>

            @auth
            <div>
                <i wire:click="triggerOptions({{$post->id}})" class="text-blue-700 cursor-pointer fas fa-chevron-down"></i>
            </div>
            @endauth
        </div>

        @if($post->content)
        <div class="p-3 sm:px-5 sm:py-3 sm:p-0">
            {{ $post->content }}
        </div>
        @endif

        @if($image_count > 0)
        <div class="@if($image_count > 1) grid grid-cols-2 gap-1 @endif bg-white">
            <div>
                <img src="/storage/{{ $post->gallery->first()->image_url }}" />
            </div>
            @if($image_count > 1 )
            <div class="grid gap-1 @if($image_count > 1 && $image_count < 4) grid-cols-1 @else grid-cols-2 @endif">
                @foreach($post->gallery as $key => $image)
                @continue($image->is($post->gallery->first()))
                @if($image_count > 2)
                @break($key === 6)
                <div style="background-image: url('/storage/{{ $image->image_url }}'); background-size: cover; background-position: center center;" class="w-full h-full">
                </div>
                @else
                <img src="/storage/{{ $image->image_url }}" />
                @endif
                @endforeach
                @if($image_count > 6)
                <div class="flex items-center justify-center bg-black">
                    <div class="text-white">
                        <i class="text-2xl fas fa-plus"></i> &nbsp; <span class="text-2xl font-bold">{{ $image_count - 6 }}</span>
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
