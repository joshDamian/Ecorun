<?php

namespace App\Http\Livewire\General\User;

use App\Mappers\NotificationMapper;
use App\Models\Profile;
use Livewire\Component;
use App\Models\DatabaseNotification;

class NotificationSorter extends Component
{
    use NotificationMapper;
    public Profile $profile;
    public string $viewIncludeFolder = "includes.notification-display-cards.";
    protected $listeners = [
        'switchedProfile',
        'deletedFromNotifications' => '$refresh',
    ];

    public function mount() {
        dump($this->notifications);
    }

    public function switchedProfile(Profile $profile) {
        $this->profile = $profile;
    }

    public function markAsRead(DatabaseNotification $notification) {
        return $notification->markAsRead();
    }

    public function switchUserProfile(Profile $profile) {
        return request()->user()->switchProfile($profile);
    }

    public function notifications() {
        return $this->profile->notifications;
    }

    public function data_for_models() {
        return $this->models->mapWithKeys(function ($model) {
            //get notification types for the model
            $notif_types = $this->model_notification_types->where('model', $model);
            $notif_keys = $notif_types->keys();

            //get the model keys
            $model_keys = $notif_keys->map(function ($key) {
                return $this->grouped_by_type->get($key)->pluck('data.model_key')->unique();
            })->flatten();

            //get model relationships and cache their queries
            $relations = $notif_types->pluck('with')->flatten()->unique()->mapWithKeys(function ($relation) {
                return [$relation => function ($query) {
                    return $query->cacheFor(3600);
                }];
            }) ?? collect([]);
            $primaryKey = (new $model)->getKeyName();
            $relation_counts = $notif_types->pluck('count')->flatten()->filter()->unique() ?? collect([]);
            return [
                $model => $model::with($relations->toArray())
                ->whereIn($primaryKey, $model_keys)
                ->withCount($relation_counts->toArray())
                ->get()
            ];
        });
    }

    public function valid_notifications() {
        $data_for_models = $this->data_for_models;
        return $this->notifications->filter(function ($notif) use ($data_for_models) {
            if ($this->model_notification_types->has($notif->type)) {
                return $this->modelValidityTest($notif, $data_for_models);
            }
            return true;
        });
    }

    public function models() {
        return $this->model_notification_types->pluck('model')->unique();
    }

    public function model_notification_types() {
        return $this->notification_types->filter(function ($type) {
            return array_key_exists('model', $type) && $type['model'] !== '';
        });
    }

    public function notification_types() {
        return $this->types->mapWithKeys(function ($type) {
            return array_key_exists($type, config('notifications.types')) ? [$type => config('notifications.types')[$type]] : [$type => []];
        });
    }

    public function modelValidityTest($notification,
        $data_for_models) {
        $notification_type = $this->model_notification_types->get($notification->type);
        $modelName = $notification_type['model'];
        $model = $data_for_models[$modelName]->find($notification->data['model_key']);
        if ($model) {
            $notification->model = $model;
            return true;
        }
        $this->notifications->forget($notification->id);
        $notification->delete();
        $this->emitSelf('deletedFromNotifications');
        return false;
    }

    public function render() {
        return view('livewire.general.user.notification-sorter');
    }
}