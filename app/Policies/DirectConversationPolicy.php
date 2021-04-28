<?php

namespace App\Policies;

use App\Models\Connect\Conversation\DirectConversation;
use App\Models\User;
use App\Models\Connect\Profile\Profile;
use Illuminate\Auth\Access\HandlesAuthorization;

class DirectConversationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Connect\Conversation\DirectConversation  $directConversation
     * @param \App\Models\Connect\Profile\Profile $profile
     * @return mixed
     */
    public function view(User $user, DirectConversation $directConversation, Profile $profile)
    {
        return $user->can('access', $profile) && $profile->conversations->directConversations->contains($directConversation);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Profile $profile, Profile $partner)
    {
        if ($profile->is($partner)) return false;
        if (!$user->can('access', $profile)) return false;
        $pair_exists = $profile->direct_conversationWith($partner);
        if ($pair_exists !== null) return false;
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Connect\Conversation\DirectConversation  $directConversation
     * @return mixed
     */
    public function update(User $user, DirectConversation $directConversation, Profile $profile)
    {
        return $user->can('access', $profile) && $profile->conversations->directConversations->contains($directConversation);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Connect\Conversation\DirectConversation  $directConversation
     * @return mixed
     */
    public function delete(User $user, DirectConversation $directConversation, Profile $profile)
    {
        return $user->can('access', $profile) && $profile->conversations->directConversations->contains($directConversation);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Connect\Conversation\DirectConversation  $directConversation
     * @return mixed
     */
    public function restore(User $user, DirectConversation $directConversation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Connect\Conversation\DirectConversation  $directConversation
     * @return mixed
     */
    public function forceDelete(User $user, DirectConversation $directConversation)
    {
        //
    }
}
