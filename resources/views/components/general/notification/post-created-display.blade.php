@props(['notification'])
<div>
    @php
    $post = $notification->model;
    $profile = $post->profile;
    @endphp

    <x-general.notification.model-profile-notif-display-card :actionUrl="$post->url->show" :profile="$profile"
        :notification="$notification">
        <x-slot name="message">
            <span class="font-bold text-black">{{ $profile->name }}</span>
            @if(!$post->content)
            added {{ $post->gallery_count }} new
            {{ ($post->gallery_count > 1) ? __('photos') : __('photo') }}
            @else
            added a new post.
            @endif
        </x-slot>

        @if($post->content)
        <x-slot name="modelData">
            {{ $post->content }}
        </x-slot>
        @endif
    </x-general.notification.model-profile-notif-display-card>
</div>
