<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @return void
     */

     /**
 * @doesNotPerformAssertions
 */
    public function testLogin()
    {
        $this->browse(function (Browser $browser){
            $browser->visit('http://jobcinema/members/login');
        });
        
    }
}
