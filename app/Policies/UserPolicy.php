<?php

namespace Um\Policies;

use Um\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function match(User $user)
    {
        return ($user->is_admin == 1) ? true : false;
    }
}
