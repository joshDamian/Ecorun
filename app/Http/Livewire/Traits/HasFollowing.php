<?php

namespace App\Http\Livewire\Traits;

use App\Http\Controllers\Connect\Profile\FollowController;
use App\Models\Connect\Profile\Profile;
use Illuminate\Support\Facades\Auth;

trait HasFollowing
{
    public $followable;
    public bool $follows = false;

    public function follow()
    {
        if (Auth::check()) {
            (new FollowController())->store($this->followable ?? (new Profile()), request());
            $this->follows = $this->follows();
            return $this->emit('modifiedFollowers');
        }
        return redirect(route('guest.follow-profile', ['tag' => $this->followable->tag]));
    }

    public function follows()
    {
        return $this->profile->following()->where('follower_id', $this->followable->id)->exists();
    }
}
