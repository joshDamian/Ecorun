<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Post;
use App\Models\Product;
use App\Models\Profile;
use App\Notifications\PostCreated;
use App\Notifications\ProductCreated;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ProfileNotificationHandler extends Component
{
    public Profile $profile;
    public string $viewIncludeFolder = "includes.notification-display-cards.";
    public array $types_array = [
        PostCreated::class => [
            'model' => Post::class,
            'with' => ['profile'],
            'count' => ['gallery'],
            'display-card' => 'post-created-display'
        ],
        ProductCreated::class => [
            'model' => Product::class,
            'with' => ['business.profile'],
            'display-card' => 'product-created-display'
        ]
    ];

    public function getNotificationsProperty(): Collection
    {
        return $this->profile->notifications;
    }

    public function getGroupedNotificationsProperty(): Collection
    {
        return $this->notifications->groupBy('type');
    }

    public function getDataForModelsProperty()
    {
        return $this->models->mapWithKeys(function ($model) {
            $notif_type = $this->model_notification_types->firstWhere('model', $model);
            $notif_key = array_keys($this->model_notification_types->all(), $notif_type, true)[0];
            return [$model => $model::with(
                collect($notif_type['with'])->mapWithKeys(function ($relation) {
                    return [$relation => function ($query) {
                        return $query->cacheFor(3600);
                    }];
                })->toArray() ?? []
            )->whereIn((new $model)->getKeyName(), $this->grouped_notifications->get($notif_key)->pluck('data.model_key')->unique())->withCount($notif_type['count'] ?? [])->get()];
        });
    }

    public function getValidNotificationsProperty(): Collection
    {
        return $this->notifications->filter(function ($notif) {
            return $this->modelValidityTest($notif);
        });
    }

    public function getModelsProperty()
    {
        return $this->model_notification_types->pluck('model');
    }

    public function getModelNotificationTypesProperty()
    {
        return $this->notification_types->filter(function ($type) {
            return $type['model'] !== "";
        });
    }

    public function getNotificationTypesProperty()
    {
        return $this->grouped_notifications->keys()->mapWithKeys(function ($type) {
            return [$type => $this->types_array[$type]];
        });
    }

    public function getListeners()
    {
        return [
            "echo-notification:App.Models.Profile.{$this->profile->id},notification" => 'handleIncoming',
            'switchedActiveProfile' => '$refresh',
        ];
    }

    public function handleIncoming($notification)
    {
        $this->emit('newNotification', $notification);
    }

    public function modelValidityTest($notification)
    {
        if (!$this->model_notification_types->has($notification->type)) {
            return true;
        }
        $notification_type = $this->model_notification_types->get($notification->type);
        $modelName = $notification_type['model'];
        $model = $this->data_for_models[$modelName]->find($notification->data['model_key']);
        if ($model) {
            return true;
        }
        $this->notifications->forget($notification->id);
        $notification->delete();
        $this->emit('deletedFromNotifications');
        return false;
    }

    public function render()
    {
        return view('livewire.connect.profile.profile-notification-handler');
    }
}
