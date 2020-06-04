<?php

namespace App\Job\Employers\Exceptions;

class EmployerNotFoundException extends \Exception
{
    public function render() 
    {
        abort(404);
    }
}