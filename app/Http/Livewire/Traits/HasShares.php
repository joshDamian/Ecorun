<?php

namespace App\Http\Livewire\Traits;

use App\Events\ContentShared;
use App\Models\Connect\Content\Share;
use App\Models\Connect\Profile\Profile;

trait HasShares
{
    public $shareable;
    public Profile $profile;
    public $feedback_id;

    public function share()
    {
        if ($this->profile) {
            $share = new Share();
            $share->profile_id = $this->profile->id;
            $share = $this->shareable->shares()->save($share);
            $event = 'newShare.' . $this->feedback_id . '.' . str_replace('\\', '.', get_class($this->shareable));
            $this->emit($event);
            try {
                broadcast(new ContentShared($share))->toOthers();
            } catch (\Throwable $th) {
                report($th);
            }
            $this->emitTo('connect.profile.profile-feed', 'sharedContent');
        }
        return;
    }

    public function shares(): int
    {
        return $this->shareable?->loadMissing('shares')->shares->count() ?? 0;
    }
}
