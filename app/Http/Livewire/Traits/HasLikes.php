<?php

namespace App\Http\Livewire\Traits;

use App\Events\LikedPost;
use App\Models\Connect\ContentFeedback\Like;
use App\Models\Connect\Content\Post;
use App\Models\Connect\Profile\Profile;

trait HasLikes
{
    public $likeable;
    public Profile $profile;
    public $feedback_id;
    protected array $likeable_events = [
        Post::class => LikedPost::class
    ];

    public function like(): void
    {
        if (isset($this->profile)) {
            $likeable_type = get_class($this->likeable);
            if ($this->liked()) {
                $this->likeable->likes()->where('profile_id', $this->profile->id)->first()->delete();
            } else {
                $like = new Like();
                $like->profile_id = $this->profile->id;
                $this->likeable->likes()->save($like);
                if (array_key_exists($likeable_type, $this->likeable_events)) {
                    $event = $this->likeable_events[$likeable_type];
                    try {
                        broadcast(new $event($like))->toOthers();
                    } catch (\Throwable $th) {
                        report($th);
                    }
                }
            }
            $event = 'newLike.' . $this->feedback_id . '.' . str_replace('\\', '.', $likeable_type);
            $this->emit($event);
            $this->emit('options_refresh.' . $this->likeable->id . str_replace('\\', '.', $likeable_type));
        }
        return;
    }

    public function likes(): int
    {
        return $this->likeable?->loadMissing('likes')->likes->count() ?? 0;
    }

    public function liked(): bool
    {
        return (isset($this->profile)) ? $this->likeable?->loadMissing('likes.profile')->likes->pluck('profile.id')->contains($this->profile?->id) : false;
    }
}
