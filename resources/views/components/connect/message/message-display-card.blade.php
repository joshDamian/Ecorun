@props(['message', 'senderView' => false])
@php
$gallery = $message->gallery;
$image_count = $gallery->count();
@endphp
<div class="max-w-full">
    @if($image_count > 0)
    @if($image_count === 1)
    <div class="mt-1 w-44">
        <x-connect.image.gallery height="h-28" view="list" curve="rounded-md" :gallery="$gallery" />
    </div>
    @else
    <div wire:ignore class="mt-1 w-52">
        <x-connect.image.gallery height="h-24" view="list" curve="rounded-md" :gallery="$gallery" />
    </div>
    @endif
    @endif

    @if($message->content)
    <div class="p-3 mt-1 @if($senderView) text-white bg-blue-600 @else text-gray-900 bg-gray-300  @endif rounded-2xl">
        <div class="flex justify-center dont-break-out">
            <span class="whitespace-pre-line">{{$message->content}}</span>
        </div>
    </div>
    @endif

    <span
        class="text-sm items-center mt-1 text-blue-700 flex @if($senderView) justify-end @else justify-start @endif font-medium ml-2">
        {{ $message->created_at->isoFormat('HH:mm') }}

        @if($senderView)
        <x-connect.message.message-status-display class="ml-1" :status="$message->status" />
        @endif
    </span>
</div>