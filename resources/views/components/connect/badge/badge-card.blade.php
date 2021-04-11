@props(['badge', 'isDisplayBadge' => false])
<div>
    @if($isDisplayBadge)
    <p class="text-gray-700">Display badge</p>
    <div class="px-2 py-1 font-semibold text-center text-green-500 border-2 border-green-500 rounded-full text-md">
        <i class="{{ $badge->icon }}"></i> {{ $badge->label }}
    </div>
    @else
    <div class="px-2 py-1 font-semibold text-center text-gray-500 border-2 border-gray-500 rounded-full text-md">
        <i class="{{ $badge->icon }}"></i> {{ $badge->label }}
    </div>
    <x-jet-secondary-button wire:click="makePrimary({{ $badge->id }})" class="mt-2">
        make disp. badge
    </x-jet-secondary-button>
    @endif
</div>
