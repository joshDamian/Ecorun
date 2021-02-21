<?php

namespace App\Http\Livewire\Traits;

trait HasFollowing {
    public $followable;
    public bool $follows = false;

    public function follow() {
        if (!auth()->user()->can('update', $this->followable)) {
            $this->profile->following()->toggle($this->followable);
            $this->follows = $this->follows();
            $this->profile->flushQueryCache();
            return $this->emit('modifiedFollowers');
        }
    }

    public function follows() {
        return $this->profile->following()->where('follower_id', $this->followable->id)->exists();
    }
}