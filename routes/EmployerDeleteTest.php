<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;
use App\Models\Employer;
use App\Models\Admin;
use App\Models\JobItem;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;

class EmployerDeleteTest extends TestCase
{


    /** @test */
    // public function employer_delete()
    // {

    //    $admin = factory(Admin::class)->create();

    //    $employer = factory(Employer::class)->create();

    //    $this->actingAs($admin);

    //    $this->assertTrue(Auth::check());

    //    $delete_jobdata = factory(JobItem::class, 20)->create();

    //    $formpath = 'dashboard/company/'.$employer->id.'/delete';

    //    $response = $this->get($formpath); // 削除実施

    //    $response->assertStatus(200);

    //    $response->assertRedirect($formpath);

    //    $response->assertSeeText('アカウントを削除しました');

    //    $response->assertStatus(200);

       


    // }

    


}
