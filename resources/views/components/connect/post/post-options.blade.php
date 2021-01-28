@props(['post'])
<x-jet-dropdown align="left">
    <x-slot name="trigger">
        <i class="text-blue-700 cursor-pointer hover:text-black focus:text-black fas fa-ellipsis-v"></i>
    </x-slot>

    <x-slot name="content">
        <div class="grid grid-cols-1 gap-1 bg-gray-200">
            <div class="px-3 py-2 bg-white">
                Edit
            </div>
        </div>
    </x-slot>
</x-jet-dropdown>
