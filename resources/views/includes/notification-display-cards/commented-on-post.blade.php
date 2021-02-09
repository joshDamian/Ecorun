<div>
    @php
    $comment = $model;
    $profile = $comment->profile;
    $post = $comment->feedbackable;
    $post_owner = $post->profile;
    $mention_case = $post->mentions->contains($this->profile->id);
    $is_owner = $post_owner->id === $this->profile->id;
    @endphp
    <div class="p-2 @if($notification->read_at) bg-gray-200 @else bg-white @endif">
        <div class="flex flex-wrap">
            <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                class="flex-shrink-0 w-10 h-10 mr-2 border border-blue-700 rounded-full">
            </div>
            <div class="flex-1 flex-shrink-0">
                <div class="grid grid-cols-1">
                    <div class="flex justify-between">
                        <span class="text-lg font-extrabold text-blue-800">{{ $notification->data['title'] }}</span>
                        <span
                            class="text-gray-700">{{ $notification->created_at->diffForHumans(null, null, true) }}</span>
                    </div>
                    <div>
                        <span class="font-bold text-black">{{ $profile->name }}</span>
                        commented on <span class="font-bold">@if($is_owner) {{ __('your post') }} @elseif ($mention_case) {{ __('a post you are mentioned in') }} @else {{ ($post_owner->id === $profile->id ) ? __('their') : $post_owner->name . "'s" }} post @endif.
                        </div>
                        @if($comment->content)
                        <div class="flex items-baseline">
                            <i class="mr-2 text-sm text-blue-800 fas fa-arrow-alt-circle-right"></i>
                            <x-display-text-content class="line-clamp flex-1 flex-shrink-0 truncate" :content="$comment->content" />
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>