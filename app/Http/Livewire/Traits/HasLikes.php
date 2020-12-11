<?php

namespace App\Http\Livewire\Traits;

use App\Models\Like;

trait HasLikes
{
    public $likeable;
    public $profile;

    public function like(): void
    {
        if ($this->liked()) {
            $this->likeable->likes()->where('profile_id', $this->profile->id)->first()->delete();
        } else {
            $like = new Like();
            $like->profile_id = $this->profile->id;
            $this->likeable->likes()->save($like);
        }
        return;
    }

    public function likes(): int
    {
        return $this->likeable->likes->count();
    }

    public function liked(): bool
    {
        return $this->likeable->likes->pluck('profile.id')->contains($this->profile->id);
    }
}
