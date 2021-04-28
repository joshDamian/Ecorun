<?php

namespace App\Traits;

use App\Models\Connect\Profile\Badge;

trait HasBadges
{
    public function badges()
    {
        return $this->morphToMany('App\Models\Connect\Profile\Badge', 'badgable');
    }

    public function primaryBadge()
    {
        return $this->belongsTo('App\Models\Connect\Profile\Badge', 'primary_badge_id')?->withDefault($this->getDefaultBadge()?->toArray());
    }

    public abstract function getBadgeCanUse();

    public function setPrimaryBadge(Badge $badge)
    {
        if ($badge) {
            $this->primary_badge_id = $badge->id;
            $this->save();
        }
    }

    abstract public function getDefaultBadge();
}
