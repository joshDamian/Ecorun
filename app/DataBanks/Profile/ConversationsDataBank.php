<?php

namespace App\DataBanks\Profile;

use App\DataBanks\DataBank;
use App\Models\Conversation;
use App\Models\Profile;

class ConversationsDatabank implements DataBank
{
    protected Profile $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
        return;
    }

    public function fetch()
    {
        $relations = collect(['messages']);
        return Conversation::with($relations->mapWithKeys(function ($relation) {
            return [$relation => function ($query) {
                $query->cacheFor(2592000);
            }];
        })->toArray())->whereJsonContains('members', $this->profile->id)->join('profiles', function ($join) {
            $join->on('profiles.id', 'in', 'conversations.members');
        })->select('profiles.* as members')->distinct()->get();
    }
}
