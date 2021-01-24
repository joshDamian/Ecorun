<?php

namespace App\Http\Livewire\Traits;

use App\Events\ContentShared;
use App\Models\Share;
use App\Models\Profile;

trait HasShares
{
    public $shareable;
    public Profile $profile;
    public $feedback_id;

    public function share()
    {
        $share = new Share();
        $share->profile_id = $this->profile->id;
        $share = $this->shareable->shares()->save($share);
        $event = 'newShare.' . $this->feedback_id . '.' . str_replace('\\', '.', get_class($this->shareable));
        $this->emit($event);
        broadcast(new ContentShared($share))->toOthers();
        $this->emitTo('connect.profile.profile-feed', 'sharedContent');
    }

    public function shares(): int
    {
        return $this->shareable->loadMissing('shares')->shares->count();
    }
}
