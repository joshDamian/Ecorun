@props(['notification'])
<div>
    @php
    $comment = $notification->model;
    $profile = $comment->profile;
    $post = $comment->feedbackable;
    $post_owner = $post->profile;
    $mention_case = $post->mentions->contains($this->profile->id);
    $is_owner = $post_owner->id === $this->profile->id;
    @endphp
    <x-general.notification.model-profile-notif-display-card
        :actionUrl="$post->url->show . '?active_comment=' . $comment->id" :profile="$profile"
        :notification="$notification">
        <x-slot name="message">
            <span class="font-bold text-black">{{ $profile->name }}</span>
            commented on <span class="font-bold">@if($is_owner) {{ __('your post.') }}
                @elseif($mention_case)
                {{ __('a post you are mentioned in.') }} @else
                {{ ($post_owner->id === $profile->id ) ? __('their') : $post_owner->name . "'s" }} post.
                @endif
        </x-slot>

        @if($comment->content)
        <x-slot name="modelData">
            {{ $comment->content }}
        </x-slot>
        @endif
    </x-general.notification.model-profile-notif-display-card>
</div>
