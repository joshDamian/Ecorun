@props(['notification', 'post', 'profile' => $post->profile])
<div>
    <div class="p-2 bg-white">
        <div class="flex flex-wrap">
            <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;" class="flex-shrink-0 w-12 h-12 mr-2 border-t-2 border-b-2 border-blue-700 rounded-full">
            </div>
            <div class="flex-1 flex-shrink-0">
                <div class="grid grid-cols-1">
                    <div class="flex justify-between">
                        <span class="text-blue-800">{{ $notification->data['title'] }}</span>
                        <span class="text-gray-700">{{ $notification->created_at->diffForHumans(null, null, true) }}</span>
                    </div>
                    @if($post->content)
                    <div class="flex items-center">
                        <i class="mr-2 text-blue-800 far fa-arrow-alt-circle-right"></i>
                        <div class="flex-1 flex-shrink-0 truncate">
                            {{ $post->content }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
