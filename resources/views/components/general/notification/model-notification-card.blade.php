@props(['notification'])
<div x-data>
    @php
    $displayCard = 'general.notification.' . $this->model_notification_types->get($notification->type)['display-card'];
    @endphp
    <div class="cursor-pointer select-none"
        x-on:click="@if(is_null($notification->read_at)) $wire.call('markAsRead', '{{ $notification->id }}');
        @endif
        $wire.call('switchUserProfile', '{{ $notification->notifiable_id }}');
        window.location='{{ (get_class($notification->model) === 'App\Models\Share') ? $notification->model->shareable->url->show : $notification->model->url->show }}'">
        <x-dynamic-component :component="$displayCard" :notification="$notification" />
    </div>
</div>
