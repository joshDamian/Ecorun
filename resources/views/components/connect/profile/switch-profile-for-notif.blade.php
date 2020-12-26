@props(['profile', 'unreadCount' => $profile->unreadNotifications->count(), 'active'])
<div x-data="{ active: '{{$active}}' }">
    <button wire:click="switchProfile('{{$profile->id}}')" type="button" :class="(active === '1') ? 'text-blue-800 bg-white border-blue-800' : 'text-gray-800 bg-gray-200 border-gray-300'" class="inline-flex items-center px-2 py-2 text-xs font-semibold tracking-normal lowercase transition duration-150 ease-in-out border rounded-full shadow-sm hover:text-blue-800 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-blue-800 active:bg-white">
        <span>
            {{ $profile->full_tag() }}
        </span>
        @if($unreadCount > 0)
        <span class="ml-2 font-extrabold text-red-700">
            {{ $unreadCount }} <sup>new</sup>
        </span>
        @endif
    </button>
</div>
