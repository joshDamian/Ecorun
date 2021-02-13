@props(['notification'])
<div>
    @php
    $product = $notification->model;
    $profile = $product->business->profile;
    @endphp

    <x-general.notification.model-profile-notif-display-card :profile="$profile" :notification="$notification">
        <x-slot name="message">
            <span class="font-bold text-black">{{ $profile->name }}</span>
            added a new product.
        </x-slot>

        <x-slot name="modelData">
            {{ $product->name }}
        </x-slot>
    </x-general.notification.model-profile-notif-display-card>
</div>