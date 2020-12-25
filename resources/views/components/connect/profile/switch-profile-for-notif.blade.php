@props(['profile', 'unread_count' => $profile->loadMissing('unreadNotifications')->unreadNotifications->count(), 'active'])
<div x-data="{ active: '{{$active}}' }">
    <div wire:click="switchProfile('{{$profile->id}}')" :class="(active === '1') ? 'text-blue-700 bg-white shadow-outline' : 'bg-gray-200 shadow-lg border-gray-200 text-gray-700 border-2'" class="flex px-2 py-1 lowercase rounded-full cursor-pointer">
        <span>
            {{ $profile->full_tag() }}
        </span>
        @if($unread_count > 0)
        <span class="ml-2 text-red-600">
            {{ $unread_count }} <sup class="p-1 text-white bg-red-600 rounded-lg">new</sup>
        </span>
        @endif
    </div>
</div>
