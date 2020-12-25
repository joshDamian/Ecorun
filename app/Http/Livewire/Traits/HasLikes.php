<?php

namespace App\Http\Livewire\Traits;

use App\Models\Like;
use App\Models\Profile;

trait HasLikes
{
    public $likeable;
    public Profile $profile;

    public function like(): void
    {
        if ($this->liked()) {
            $this->likeable->likes()->where('profile_id', $this->profile->id)->first()->delete();
        } else {
            $like = new Like();
            $like->profile_id = $this->profile->id;
            $this->likeable->likes()->save($like);
        }

        $this->emit('newLike');
        
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
