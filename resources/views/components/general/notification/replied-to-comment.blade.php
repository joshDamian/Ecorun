@props(['notification'])
<div>
    @php
    $reply = $notification->model;
    $reply_profile = $reply->profile;
    $comment = $reply->feedbackable;
    $comment_profile = $comment->profile;
    $post_owner = $comment->feedbackable->profile;
    $mention_case = $comment->mentions->contains($this->profile->id);
    $is_owner = $comment_profile->id === $this->profile->id;
    @endphp
    <div class="p-2 @if($notification->read_at) bg-gray-200 @else bg-white @endif">
        <div class="flex flex-wrap">
            <div style="background-image: url('{{ $reply_profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                class="flex-shrink-0 w-8 h-8 mr-2 border border-blue-700 rounded-full">
            </div>
            <div class="flex-1">
                <div class="grid grid-cols-1">
                    <div class="flex justify-between">
                        <span class="text-lg font-extrabold text-blue-800">{{ $notification->data['title'] }}</span>
                        <span
                            class="text-gray-700">{{ $notification->created_at->diffForHumans(null, null, true) }}</span>
                    </div>
                    <div>
                        <span class="font-bold text-black">{{ $reply_profile->name }}</span>
                        replied to <span class="font-bold">@if($is_owner) {{ __('your comment') }}
                            @elseif($mention_case)
                            {{ __('a comment you are mentioned in,') }} @else
                            {{ ($comment_profile->id === $reply_profile->id ) ? __('their comment') : $comment_profile->name . "'s" }}
                            comment @endif on
                            {{ ($post_owner->id === $reply_profile->id) ? __('their post.') : (($post_owner->id === $this->profile->id) ? __('your post.') : $post_owner->name . "'s post.") }}
                    </div>
                    @if($reply->content)
                    <div class="flex items-baseline">
                        <i class="mr-2 text-sm text-blue-800 fas fa-arrow-alt-circle-right"></i>
                        <div class="flex-1 break-words line-clamp-1">
                            {{ $reply->content }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
