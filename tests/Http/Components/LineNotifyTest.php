<?php

namespace Tests\Http\Components;

use Tests\TestCase;
use App\Http\Components\LineNotify;

class LineNotifyTest extends TestCase
{

    /** @test */
    public function it_can_notify_by_line()
    {
        $stub = $this->createMock(LineNotify::class);

        $stub->method('lineNotify')
            ->willReturn(true);

        $this->assertSame(true, $stub->lineNotify("test"));
    }
}
