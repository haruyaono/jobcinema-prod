<?php

namespace App\Job\Users\Exceptions;

class UserNotFoundException extends \Exception
{
    public function render() 
    {
        return view('errors.employer.custom')->with('error_name', 'NotApplicatUser');
    }
}