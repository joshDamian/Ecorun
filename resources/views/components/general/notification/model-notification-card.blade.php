@props(['notification'])
<div x-data>
    @php
    $displayCard = 'general.notification.' . $this->model_notification_types->get($notification->type)['display-card'];
    @endphp
    <x-dynamic-component :component="$displayCard" :notification="$notification" />
</div>
