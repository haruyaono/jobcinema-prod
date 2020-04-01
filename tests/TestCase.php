<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

 
   /**
     * Set the referer header to simulate a previous request.
     *
     * @param  string  $url
     * @return $this
     */
    public function from(string $url)
    {
        session()->setPreviousUrl(url($url));
        return $this;
    }
}
