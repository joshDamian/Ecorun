@props(['profile','unreadCount','active'])
<div x-data="{ active: '{{$active}}' }" :class="(active) ? 'text-blue-700 bg-white' : ''"
    class="px-3 py-2 cursor-pointer hover:bg-white hover:text-blue-700"
    wire:click="switchProfile('{{ $profile->id }}')">
    <span>
        {{ $profile->full_tag() }}
    </span>
    @if($unreadCount > 0)
    <sup class="flex-shrink-0 ml-1 fa-stack fa-1x">
        <i style="font-size: 23px;" class="text-red-600 far fa-circle fa-stack-1x"></i>
        <span class="text-xs font-extrabold text-red-600 fa-stack-1x">{{ $unreadCount  }}</span>
    </sup>
    @endif
</div>
