<?php

namespace App\View\Components;

use App\Mappers\NotificationMapper;
use App\Models\Post;
use App\Models\Product;
use App\Notifications\PostCreated;
use App\Notifications\ProductCreated;
use Illuminate\View\Component;

class NotificationSorter extends Component
{
    use NotificationMapper;
    public $notifications;
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

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($notifications)
    {
        $this->notifications = $notifications;
    }

    public function data_for_models()
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
            )->whereIn((new $model)->getKeyName(), $this->grouped_by_type->get($notif_key)->pluck('data.model_key')->unique())->withCount($notif_type['count'] ?? [])->get()];
        });
    }

    public function valid_notifications()
    {
        return $this->all->filter(function ($notif) {
            return $this->modelValidityTest($notif);
        });
    }

    public function models()
    {
        return $this->model_notification_types->pluck('model');
    }

    public function model_notification_types()
    {
        return $this->notification_types->filter(function ($type) {
            return $type['model'] !== "";
        });
    }

    public function notification_types()
    {
        return $this->types->mapWithKeys(function ($type) {
            return [$type => $this->types_array[$type]];
        });
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
        $this->all->forget($notification->id);
        $notification->delete();
        return false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.notification-sorter');
    }
}
