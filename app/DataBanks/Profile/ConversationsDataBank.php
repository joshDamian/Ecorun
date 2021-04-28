<?php

namespace App\DataBanks\Profile;

use App\DataBanks\DataBank;
use App\Models\Connect\Conversation\DirectConversation;
use App\Models\Connect\Conversation\GroupConversation;
use App\Models\Connect\Profile\Profile;

class ConversationsDataBank implements DataBank
{
    protected Profile $profile;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function fetch()
    {
        if ($this->profile instanceof Profile) {
            $direct_relations = collect(['initiator', 'joined', 'messages']);
            $group_relations = collect(['messages']);
            $direct_conversations = DirectConversation::with(
                $direct_relations->mapWithKeys(function ($relation) {
                    return [$relation => function ($query) {
                        return $query->cacheFor(2592000);
                    }];
                })->toArray()
            )->where('initiator_id', $this->profile->id)->orWhere('joined_id', $this->profile->id)->distinct()->get();
            $group_conversations = GroupConversation::with($group_relations->mapWithKeys(function ($relation) {
                return [$relation => function ($query) {
                    return $query->cacheFor(2592000);
                }];
            })->toArray())->whereExists(function ($query) {
                $query->select('*')
                    ->from('group_conversation_member')
                    ->whereRaw("group_conversation_member.member_id = {$this->profile->id}");
            })->distinct()->get();
            return collect([DirectConversation::class => $direct_conversations, GroupConversation::class => $group_conversations]);
        }
    }
}
