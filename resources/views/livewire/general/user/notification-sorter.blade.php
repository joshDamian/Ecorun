<div x-data x-init="() => { Livewire.on('shouldRefresh', () => {
        @this.call('refreshNotification');
    }) }">
    <div class="w-full" wire:loading wire:target="mount, refreshNotification">
        <x-loader_2 />
    </div>
    <div class="grid grid-cols-1 gap-1 bg-gray-300">
        @forelse($this->valid_notifications as $notification)
        @if($this->model_notification_types->has($notification->type))
        @php
        $notification_type = $this->model_notification_types->get($notification->type);
        $modelName = $notification_type['model'];
        $model = $this->data_for_models[$modelName]->find($notification->data['model_key']);
        @endphp
        <div
            onclick="@if(is_null($notification->read_at)) Livewire.emit('markAsRead', '{{ $notification->id }}'); @endif window.location = '{{ $model->url->show }}'">
            @include($this->viewIncludeFolder . $notification_type['display-card'], ['model' => $model])
        </div>
        @endif
        @continue
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
