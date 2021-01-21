<?php

namespace App\Http\Livewire\Traits;

use App\Models\Share;
use App\Models\Profile;

trait HasShares
{
    public $shareable;
    public Profile $profile;

    public function share()
    {
        $share = new Share();
        $share->profile_id = $this->profile->id;
        $this->shareable->shares()->save($share);
        $this->emit('newShare.' . $this->shareable->id);
    }

    public function shares(): int
    {
        return $this->shareable->loadMissing('shares')->shares->count();
    }
}
