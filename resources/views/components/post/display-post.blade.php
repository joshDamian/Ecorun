@props(['post', 'image_count' => $post->gallery->count() ])
<div>
    <div class="bg-gray-100 sm:shadow">
        <div class="p-2 sm:px-5 sm:py-3 sm:p-0 border-b flex justify-between border-gray-200">
            <a class="block" href="{{ route('timeline.show', ['profile' => $post->profile->id, 'slug' => $post->profile->profileable->data_slug('name')]) }}">
                <div class="flex items-center">
                    <div style="background-image: url('{{ $post->profile->profile_image() }}'); background-size: cover; background-position: center center;" class="w-12 rounded-full mr-3 h-12">
                    </div>
                    <div>
                        <span class="text-md text-blue-700 font-medium">{{ $post->profile->name() }}</span>
                        <div class="text-gray-500 text-sm font-normal">
                            {{ $post->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </a>
            <div>
                <i wire:click="triggerOptions({{$post->id}})" class="fas fa-chevron-down cursor-pointer text-blue-700"></i>
            </div>
        </div>

        @if($post->content)
        <div class="p-2 sm:px-5 sm:py-3 sm:p-0">
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
                @break($key === 4)
                <div style="background-image: url('/storage/{{ $image->image_url }}'); background-size: cover; background-position: center center;" class="h-full w-full">
                </div>
                @else
                <img src="/storage/{{ $image->image_url }}" />
                @endif
                @endforeach
                @if($image_count > 4)
                <div class="bg-black flex justify-center items-center">
                    <div class="text-white">
                        <i class="fas text-2xl fa-plus"></i> &nbsp; <span class="text-2xl font-bold">{{ $image_count - 4 }}</span>
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>
        @endif
    </div>
</div>