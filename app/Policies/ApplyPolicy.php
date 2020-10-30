<?php

namespace App\Policies;

use App\Job\Users\User;
use App\Job\Applies\Apply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplyPolicy
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

    public function view(User $user, Apply $apply)
    {
        return $user->id === $apply->user_id;
    }

    public function update(User $user, Apply $apply)
    {
        return $user->id === $apply->user_id;
    }
}
