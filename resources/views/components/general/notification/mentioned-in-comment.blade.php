@props(['notification'])
<div>
    @php
    $comment = $notification->model;
    $profile = $comment->profile;
    @endphp

    <x-general.notification.model-profile-notif-display-card
        :actionUrl="$comment->feedbackable->url->show . '?active_comment=' . $comment->id" :profile="$profile"
        :notification="$notification">
        <x-slot name="message">
            <span class="font-bold text-black">{{ $profile->name }}</span>
            mentioned you in a comment.
        </x-slot>

        @if($comment->content)
        <x-slot name="modelData">
            {{ $comment->content }}
        </x-slot>
        @endif
    </x-general.notification.model-profile-notif-display-card>
</div>
