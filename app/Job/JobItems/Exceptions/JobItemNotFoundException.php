<?php

namespace App\Job\JobItems\Exceptions;

class JobItemNotFoundException extends \Exception
{
    public function render()
    {
        abort(404);
    }
}