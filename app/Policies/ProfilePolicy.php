<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ProfilePolicy
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
    * @param  \App\Models\Profile  $profile
    * @return mixed
    */
    public function view(User $user, Profile $profile) {
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
    * @param  \App\Models\Profile  $profile
    * @return mixed
    */
    public function update(User $user, Profile $profile) {
        return ($user->currentProfile->id === $profile->id && $user->can('access', $profile));
    }

    public function access(User $user, Profile $profile) {
        if ($profile->isBusiness()) {
            return $user->teams->pluck('business')->contains($profile->profileable) || ($user->isManager) ? $user->isManager->id === $profile->profileable->manager_id : false;
        } else {
            return $user->id === $profile->profileable->id;
        }
    }

    /**
    * Determine whether the user can delete the model.
    *
    * @param  \App\Models\User  $user
    * @param  \App\Models\Profile  $profile
    * @return mixed
    */
    public function delete(User $user, Profile $profile) {
        //
    }

    /**
    * Determine whether the user can restore the model.
    *
    * @param  \App\Models\User  $user
    * @param  \App\Models\Profile  $profile
    * @return mixed
    */
    public function restore(User $user, Profile $profile) {
        //
    }

    /**
    * Determine whether the user can permanently delete the model.
    *
    * @param  \App\Models\User  $user
    * @param  \App\Models\Profile  $profile
    * @return mixed
    */
    public function forceDelete(User $user, Profile $profile) {
        //
    }
}