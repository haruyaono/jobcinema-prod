<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employer;
use App\Models\Apply;
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

    public function viewEmployer(Employer $employer, Apply $apply)
    {
        $filtered = $employer->jobitems->filter(function ($jobitem) use ($apply) {
            return $jobitem->id === $apply->job_item_id;
        });

        return $filtered->isNotEmpty();
    }

    public function updateEmployer(Employer $employer, Apply $apply)
    {
        $filtered = $employer->jobitems->filter(function ($jobitem) use ($apply) {
            return $jobitem->id === $apply->job_item_id;
        });

        return $filtered->isNotEmpty();
    }
}
