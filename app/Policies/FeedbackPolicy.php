<?php

namespace App\Policies;

use App\Models\Feedback;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedbackPolicy
{
    use HandlesAuthorization;

    /**
    * Determine whether the user can view any models.
    *
    * @param  \App\Models\User  $user
    * @return mixed
    */
    public function viewAny(User $user) {
        //
    }

    /**
    * Determine whether the user can view the model.
    *
    * @param  \App\Models\User  $user
    * @param  \App\Models\Feedback  $feedback
    * @return mixed
    */
    public function view(User $user, Feedback $feedback) {
        //
    }

    /**
    * Determine whether the user can create models.
    *
    * @param  \App\Models\User  $user
    * @return mixed
    */
    public function create(User $user) {
        //
    }

    /**
    * Determine whether the user can update the model.
    *
    * @param  \App\Models\User  $user
    * @param  \App\Models\Feedback  $feedback
    * @return mixed
    */
    public function update(User $user, Feedback $feedback, Profile $profile) {
        return $user->can('access', $profile) && ($feedback->profile_id === $profile->id);
    }

    /**
    * Determine whether the user can delete the model.
    *
    * @param  \App\Models\User  $user
    * @param  \App\Models\Feedback  $feedback
    * @return mixed
    */
    public function delete(User $user, Feedback $feedback) {
        //
    }

    /**
    * Determine whether the user can restore the model.
    *
    * @param  \App\Models\User  $user
    * @param  \App\Models\Feedback  $feedback
    * @return mixed
    */
    public function restore(User $user, Feedback $feedback) {
        //
    }

    /**
    * Determine whether the user can permanently delete the model.
    *
    * @param  \App\Models\User  $user
    * @param  \App\Models\Feedback  $feedback
    * @return mixed
    */
    public function forceDelete(User $user, Feedback $feedback) {
        //
    }
}