@props(['message', 'senderView' => false])
<div class="max-w-full">
    <div>
        @php
        $gallery = $message->gallery;
        $image_count = $gallery->count();
        @endphp
    </div>
    <div>
        @if($image_count > 0 && $image_count === 1)
        <div id="message_image_{{ $message->id . mt_rand(30, 65448907554) . time() }}" class="mt-1 w-44">
            <x-connect.image.gallery height="h-32" view="list" curve="rounded-md" :gallery="$gallery" />
        </div>
        @elseif($image_count > 0 && $image_count > 1)
        <div id="message_image_{{ $message->id . mt_rand(3, 6544567) . microtime() }}" class="mt-1 w-52">
            <x-connect.image.gallery height="h-24" view="list" curve="rounded-md" :gallery="$gallery" />
        </div>
        @endif
    </div>

    <div>
        @if($message->content)
        <div class="p-3 mt-1 @if($senderView) text-white bg-blue-600 @else text-gray-900 bg-gray-300  @endif rounded-2xl">
            <div class="flex justify-center dont-break-out">
                <span class="whitespace-pre-line">{{$message->content}}</span>
            </div>
        </div>
        @endif
    </div>

    <div
        class="text-sm items-center mt-1 text-blue-700 flex @if($senderView) justify-end @else justify-start @endif font-medium ml-2">
        {{ $message->created_at->isoFormat('HH:mm') }}

        @if($senderView)
        <x-connect.message.message-status-display class="ml-1" :status="$message->status" />
        @endif
    </div>
</div>