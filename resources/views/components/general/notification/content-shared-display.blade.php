@props(['notification'])
<div>
    @php
    $share = $notification->model;
    $profile = $share->profile;
    @endphp

    <x-general.notification.model-profile-notif-display-card :profile="$profile" :notification="$notification">
        <x-slot name="message">
            <span class="font-bold text-black">{{ $profile->name }}</span>
            shared @switch($share->shareable_type)
            @case('App\Models\Post')
            a post.
            @if($share->shareable->content)
            <div class="flex items-center">
                <i class="mr-2 text-sm text-blue-800 fas fa-arrow-alt-circle-right"></i>
                <div class="flex-1 break-words line-clamp-1">
                    {{ $share->shareable->content }}
                </div>
            </div>
            @endif
            @break
            @case('App\Models\Product')
            a product.
            <div class="flex items-center">
                <i class="mr-2 text-sm text-blue-800 fas fa-arrow-alt-circle-right"></i>
                <div class="flex-1 break-words line-clamp-1">
                    {{ $share->shareable->name }}
                </div>
            </div>
            @break
            @default
            @break;
            @endswitch
        </x-slot>
    </x-general.notification.model-profile-notif-display-card>
</div>
