<?php

use Tests\TestCase;
use App\Traits\IsMobile;
use Illuminate\Http\Request;

class IsMobileTest extends TestCase
{

    public function testIsMobileTest()
    {

        $mock = $this->getMockForTrait(IsMobile::class);

        $symfonyRequest = Request::create(
            route('top.get'), 'GET', [],
            [], [], []);

        $request = Request::createFromBase($symfonyRequest);
        $responseValue = $mock->isMobile($request);

        $this->assertInternalType('string',$responseValue);
    }
}