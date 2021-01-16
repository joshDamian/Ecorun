@props(['message', 'senderView' => false])
<div class="max-w-full">
    @if($message->content)
    <div class="p-3 @if($senderView) text-white bg-blue-600 @else text-gray-900 bg-gray-300  @endif rounded-2xl">
        <div class="dont-break-out flex justify-center">
            <span class="whitespace-pre-line">{{$message->content}}</span>
        </div>
    </div>
    <span class="text-sm items-center mt-1 text-blue-700 flex @if($senderView) justify-end @else justify-start @endif font-medium ml-2">
        {{ $message->created_at->isoFormat('HH:mm') }}

        @if($senderView)
        <x-connect.message.message-status-display class="ml-1" :status="$message->status" />
        @endif
    </span>
    @endif
</div>