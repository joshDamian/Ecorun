<div class="grid-cols-1 gap-2 bg-gray-100">
    @forelse($this->valid_notifications as $notification)
    @if($this->model_notification_types->has($notification->type))
    @php
    $notification_type = $this->model_notification_types->get($notification->type);
    $modelName = $notification_type['model'];
    $model = $this->data_for_models[$modelName]->find($notification->data['model_key']);
    @endphp
    <div>
        @include($this->viewIncludeFolder . $notification_type['display-card'], ['model' => $model])
    </div>
    @endif
    @continue
    @empty
    <div class="p-3 text-blue-700">
        <div class="flex items-center justify-center justify-items-center">
            <i style="font-size: 5rem;" class="far fa-bell"></i>
        </div>
        <div class="pt-3 text-lg font-semibold text-center">no notifications yet.</div>
    </div>
    @endforelse
</div>
