<?php

namespace App\Policies;

use App\Job\Users\User;
use App\Job\JobItems\JobItem;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;

class JobItemPolicy
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

    public function viewAppJob(User $user, JobItem $jobitem) {
        if($jobitem === null) {
            return false;
        }

        return $user->whereHas('users', function(Builder $query) use ($jobitem) {
            $query->where('job_item_id', $jobitem->id);
        });
    }
}
