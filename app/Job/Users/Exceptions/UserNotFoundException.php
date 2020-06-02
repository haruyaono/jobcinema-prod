<?php

namespace App\Job\Users\Exceptions;

class UserNotFoundException extends \Exception
{
    public function render() 
    {
        abort(404);
    }
}