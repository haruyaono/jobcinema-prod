<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;
use App\Models\JobItem;
use App\Models\Employer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;

class EmployerLogin extends TestCase
{

    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $employer = factory(Employer::class)->create();
        $jobitem = factory(JobItem::class)->create();
    }
    
    /** @test */
    public function employer_can_view_job_main_image($id='')
    {

        $response = $this->actingAs($employer)
                         ->get('/jobs/main/image/'.$jobitem->id);
    }

    

}
