@props(['enterprise'])
<div>
    @if ($enterprise->coverPhoto())
    <div
        style="height:140px; width: 100%; background-image: url('/storage/{{ $enterprise->coverPhoto() }}'); background-position: center center; background-size: cover;">
    </div>
    @else
    <div style="height:140px; width: 100%;" class="flex items-center bg-white py-3 px-3 justify-center">
        <i style="font-size: 5rem;" class="fa text-blue-600 fa-store-alt"></i>
    </div>
    @endif
</div>