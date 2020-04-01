<?php

namespace Tests\Http\Controllers\Employer;

use Tests\TestCase;
use App\Models\Employer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;

class EmployerLogin extends TestCase
{

    /** @test */
    public function employer_can_view_login()
    {
        $response = $this->get('/employer/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function unauthenticated_employer_cannot_view_home()
    {
        $response = $this->get('company/mypage');
        $response->assertRedirect('/');
    }

    /** @test */
    public function inValid_employer_can_login()
    {
        $employer = factory(Employer::class)->create([
            'password'  => bcrypt('test1111'),
            'status'  => 0
        ]);
        
        $response = $this->from('employer/login')->post('employer/login', [
            'email'    => $employer->email,
            'password' => 'test1111'
        ]);

        $this->assertFalse(Auth::guard('employer')->check());

        $response->assertStatus(302);
        $response->assertRedirect('employer/login');
    
        $response->assertSessionHas('flash_message_danger','本登録が終わっておりません。
                    送付された仮登録完了メールから本登録をしてください。'
        );
    }

    /** @test */
    public function valid_employer_can_login()
    {
        $employer = factory(Employer::class)->create([
            'password'  => bcrypt('test1111'),
            'status'  => 1
        ]);

        $this->assertFalse(Auth::guard('employer')->check());
        
        $response = $this->post('employer/login', [
            'email'    => $employer->email,
            'password' => 'test1111'
        ]);


        $this->assertTrue(Auth::guard('employer')->check());

        $response->assertRedirect('company/mypage');
    }

}
