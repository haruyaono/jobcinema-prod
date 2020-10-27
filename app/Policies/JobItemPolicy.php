<?php

namespace App\Policies;

use App\Job\Employers\Employer;
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

    public function view(Employer $employer, JobItem $jobitem)
    {
        return $employer->id === $jobitem->company->employer_id;
    }

    public function update(Employer $employer, JobItem $jobitem)
    {
        return $employer->id === $jobitem->company->employer_id;
    }

    public function delete(Employer $employer, JobItem $jobitem)
    {
        return $employer->id === $jobitem->company->employer_id;
    }
}
