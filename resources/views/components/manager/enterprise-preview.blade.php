@props(['enterprise'])
<div>
    @if ($enterprise->coverPhoto())
    <div class="">

    </div>
    @else
    <div class="flex bg-white py-3 px-3 justify-center">
        <i style="font-size: 5rem;" class="fa text-blue-600 fa-store-alt"></i>
    </div>
    @endif
    <div class="bg-blue-600 text-white truncate font-bold text-md text-center py-2 px-2">
        {{ $enterprise->name }}
    </div>
</div>
