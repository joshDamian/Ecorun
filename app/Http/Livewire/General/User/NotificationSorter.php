<?php

namespace App\Http\Livewire\General\User;

use App\Mappers\NotificationMapper;
use App\Models\Profile;
use App\Models\User;
use Livewire\Component;
use Illuminate\Notifications\DatabaseNotification;

class NotificationSorter extends Component
{
    use NotificationMapper;
    public Profile $profile;
    public $notifications_incoming;
    public string $viewIncludeFolder = "includes.notification-display-cards.";
    protected $listeners = [
        'switchedProfile',
        //'newNotification',
        'deletedFromNotifications' => '$refresh'
    ];

    public function switchedProfile(Profile $profile) {
        $this->profile = $profile;
    }

    public function handle(DatabaseNotification $notification, $redirect) {
        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }
        request()->user()->switchProfile($notification->loadMissing('notifiable')->notifiable);
        $this->redirect($redirect);
    }

    public function notifications() {
        return collect($this->notifications_incoming)->groupBy('notifiable_id')[$this->profile->id] ?? collect([]);
    }

    public function data_for_models() {
        return $this->models->mapWithKeys(function ($model) {
            $notif_type = $this->model_notification_types->firstWhere('model', $model);
            $notif_key = array_keys($this->model_notification_types->all(), $notif_type, true)[0];
            return [$model => $model::with(
                collect($notif_type['with'])->mapWithKeys(function ($relation) {
                    return [$relation => function ($query) {
                        return $query->cacheFor(3600);
                    }];
                })->toArray() ?? []
            )->whereIn((new $model)->getKeyName(), $this->grouped_by_type->get($notif_key)->pluck('data.model_key')->unique())->withCount($notif_type['count'] ?? [])->get()];
        });
    }

    public function valid_notifications() {
        return $this->all->filter(function ($notif) {
            return $this->modelValidityTest($notif);
        });
    }

    public function models() {
        return $this->model_notification_types->pluck('model');
    }

    public function model_notification_types() {
        return $this->notification_types->filter(function ($type) {
            return $type['model'] !== "";
        });
    }

    public function notification_types() {
        return $this->types->mapWithKeys(function ($type) {
            return [$type => config('notifications.types')[$type]];
        });
    }

    public function modelValidityTest($notification) {
        if (!$this->model_notification_types->has($notification->type)) {
            return true;
        }
        $notification_type = $this->model_notification_types->get($notification->type);
        $modelName = $notification_type['model'];
        $model = $this->data_for_models[$modelName]->find($notification->data['model_key']);
        if ($model) {
            return true;
        }
        $this->all->forget($notification->id);
        $notification->delete();
        $this->emit('deletedFromNotifications');
        return false;
    }

    public function render() {
        return view('livewire.general.user.notification-sorter');
    }
}