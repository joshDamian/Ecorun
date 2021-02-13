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

    <x-general.notification.model-profile-notif-display-card :profile="$reply_profile" :notification="$notification">
        <x-slot name="message">
            <span class="font-bold text-black">{{ $reply_profile->name }}</span>
            replied to <span class="font-bold">@if($is_owner) {{ __('your comment') }}
                @elseif($mention_case)
                {{ __('a comment you are mentioned in,') }} @else
                {{ ($comment_profile->id === $reply_profile->id ) ? __('their comment') : $comment_profile->name . "'s" }}
                comment @endif on
                {{ ($post_owner->id === $reply_profile->id) ? __('their post.') : (($post_owner->id === $this->profile->id) ? __('your post.') : $post_owner->name . "'s post.") }}
            </span>
        </x-slot>

        @if($reply->content)
        <x-slot name="modelData">
            {{ $reply->content }}
        </x-slot>
        @endif
    </x-general.notification.model-profile-notif-display-card>
</div>