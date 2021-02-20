<?php

namespace App\Http\Livewire\Traits;

use App\Events\LikedPost;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;

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
        return;
    }

    public function likes(): int
    {
        return $this->likeable->loadMissing('likes')->likes->count();
    }

    public function liked(): bool
    {
        return $this->likeable->loadMissing('likes.profile')->likes->pluck('profile.id')->contains($this->profile->id);
    }
}
