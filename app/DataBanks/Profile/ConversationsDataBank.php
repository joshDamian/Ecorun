<?php

namespace App\DataBanks\Profile;

use App\DataBanks\DataBank;
use App\Models\Conversation;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;

class ConversationsDatabank implements DataBank
{
    protected Profile $profile;

    public function __construct(Profile $profile) {
        $this->profile = $profile;
    }

    public function fetch() {
        $relations = collect(['messages']);
        return Conversation::with($relations->mapWithKeys(function ($relation) {
            return [$relation => function ($query) {
                $query->cacheFor(2592000)->latest();
            }];
        })->toArray())->whereJsonContains('members', $this->profile->id)->distinct()->latest('updated_at')->get();
    }
}