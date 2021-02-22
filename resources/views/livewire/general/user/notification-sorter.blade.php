<div x-data x-init="() => {
    Echo.private('App.Models.Profile.{{$profile->id}}').listen('NewMessageForProfile', () => {
    Livewire.emit('newMessage')
    }).notification((notification) => {
    Livewire.emit('newNotification', notification);
    $wire.call('$refresh');
    });
    }">
    <div class="w-full" wire:loading wire:target="mount,profile">
        <x-loader_2 />
    </div>

    <div class="grid grid-cols-1 gap-0.5 bg-gray-300">
        @forelse($this->valid_notifications as $key => $notification)
        @if($this->model_notification_types->has($notification->type))
        <x-general.notification.model-notification-card :notification="$notification" />
        @endif
        @empty
        <div class="p-3 text-blue-700 bg-gray-100">
            <div class="flex items-center justify-center justify-items-center">
                <i style="font-size: 5rem;" class="far fa-bell"></i>
            </div>
            <div class="pt-3 text-lg font-semibold text-center">
                no notifications yet.
            </div>
        </div>
        @endforelse
    </div>
</div>