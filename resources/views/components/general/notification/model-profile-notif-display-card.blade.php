@props(['notification', 'profile', 'actionUrl' => '#'])
<div x-on:click="@if(is_null($notification->read_at)) $wire.call('markAsRead', '{{ $notification->id }}');
    @endif
    $wire.call('switchUserProfile', '{{ $notification->notifiable_id }}');
    window.location='{{ $actionUrl }}'"
    class="p-2 cursor-pointer select-none @if($notification->read_at) bg-gray-200 bg-opacity-50 @else bg-white @endif">
    <div class="flex flex-wrap">
        <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
            class="flex-shrink-0 w-8 h-8 mr-2 border border-blue-700 rounded-full">
        </div>
        <div class="flex-1">
            <div class="grid grid-cols-1">
                <div class="flex justify-between">
                    <span class="text-lg font-bold text-blue-700">{{ $notification->data['title'] }}</span>
                    <span class="text-gray-700">{{ $notification->created_at->diffForHumans(null, null, true) }}</span>
                </div>

                <x-general.notification.message-card>
                    {{ $message }}
                </x-general.notification.message-card>

                @if($modelData ?? false)
                <div class="flex items-baseline">
                    <i class="mr-2 text-sm text-blue-700 fas fa-arrow-alt-circle-right"></i>
                    <div class="flex-1 break-words line-clamp-1">
                        {{ $modelData ?? '' }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
