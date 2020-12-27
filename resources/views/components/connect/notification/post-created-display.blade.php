@props(['notification', 'post', 'profile' => $post->profile])
<div>
    <a href="{{ route('post.show', ['post' => $post->id]) }}">
        <div class="p-2 @if($notification->read_at) bg-gray-200 @else bg-white @endif">
            <div class="flex flex-wrap">
                <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;" class="flex-shrink-0 w-12 h-12 mr-2 border-t-2 border-b-2 border-blue-700 rounded-full">
                </div>
                <div class="flex-1 flex-shrink-0">
                    <div class="grid grid-cols-1">
                        <div class="flex justify-between">
                            <span class="text-lg font-extrabold text-blue-800">{{ $notification->data['title'] }}</span>
                            <span class="text-gray-700">{{ $notification->created_at->diffForHumans(null, null, true) }}</span>
                        </div>
                        <div>
                            <span class="font-bold text-black">{{ $profile->name }}</span>
                            @if(!$post->content)
                            added {{ $post->gallery_count }} new {{ ($post->gallery_count > 1) ? __('photos') : __('photo') }}
                            @else
                            added a new post.
                            @endif
                        </div>
                        @if($post->content)
                        <div class="flex items-center">
                            <i class="mr-2 text-sm text-blue-800 fas fa-arrow-alt-circle-right"></i>
                            <div class="flex-1 flex-shrink-0 break-words truncate line-clamp">
                                {!! $post->content !!}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
