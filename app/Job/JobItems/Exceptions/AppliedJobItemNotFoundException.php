<?php

namespace App\Job\JobItems\Exceptions;

class AppliedJobItemNotFoundException extends \Exception
{
    public function render()
    {
        return view('errors.employer.custom')->with('error_name', 'NotAppliedJobItem');
    }
}