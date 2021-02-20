@props(['notification'])
<div>
    @php
    $like = $notification->model;
    $profile = $like->profile;
    $post = $like->likeable;
    $post_owner = $post->profile;
    $mention_case = $post->mentions->contains($this->profile->id);
    $is_owner = $post_owner->id === $this->profile->id;
    @endphp
    <x-general.notification.model-profile-notif-display-card :actionUrl="$post->url->show" :profile="$profile"
        :notification="$notification">
        <x-slot name="message">
            <span class="font-bold text-black">{{ $profile->name }}</span>
            liked <span class="font-bold">@if($is_owner) {{ __('your post.') }}
                @elseif($mention_case)
                {{ __('a post you are mentioned in.') }} @else
                {{ ($post_owner->id === $profile->id ) ? __('their') : $post_owner->name . "'s" }} post.
                @endif
        </x-slot>
    </x-general.notification.model-profile-notif-display-card>
</div>
