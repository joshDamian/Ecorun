<?php

namespace App\Policies;

use App\Models\Information\Basic\Contact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(object $contactable)
    {
        return $contactable->contacts->count() <= 2;
    }
}
