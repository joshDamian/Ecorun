<div x-data x-init="() => {
    Echo.private('App.Models.Profile.{{$profile->id}}').listen('NewMessageForProfile', () => {
        Livewire.emit('newMessage')
    }).notification((notification) => {
        Livewire.emit('newNotification', notification);
        @this.call('$refresh');
    });
}">
    <div class="w-full" wire:loading wire:target="mount,profile">
        <x-loader_2 />
    </div>
    <div class="grid grid-cols-1 gap-1 bg-gray-300">
        @forelse($this->valid_notifications as $notification)
        @if($this->model_notification_types->has($notification->type))
        @php
        $notification_type = $this->model_notification_types->get($notification->type);
        @endphp
        <div class="cursor-pointer"
            onclick="@if(is_null($notification->read_at)) @this.call('markAsRead', '{{ $notification->id }}'); @endif @this.call('switchUserProfile', '{{ $notification->notifiable_id }}'); window.location='{{ (get_class($notification->model) === 'App\Models\Share') ? $notification->model->shareable->url->show : $notification->model->url->show }}'">
            @include($this->viewIncludeFolder . $notification_type['display-card'], ['model' => $notification->model])
        </div>
        @continue
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
