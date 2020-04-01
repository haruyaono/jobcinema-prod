<?php

namespace Tests\Http\Controllers\Employer;

use Tests\TestCase;
use App\Models\Employer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;

class EmployerRegister extends TestCase
{

    /** @test */
    public function employer_can_view_pre_register()
    {
        $response = $this->get('/employer/getpage');
        $response->assertStatus(200);
    }

    /** @test */
    public function employer_can_pre_register()
    {
        $data = [
            'email' => 'test@test.com',
            'password' => 'test1111',
            'password_confirmation' => 'test1111',
            'c_name' => 'test_company',
            'last_name' => 'test',
            'first_name' => 'test',
            'phone1' => '080',
            'phone2' => '1111',
            'phone3' => '1111'
        ];

        $response = $this->from('employer/getpage')->post('employer/confirm', [
            'email' => 'test@test.com',
            'password' => 'test1111',
            'password_confirmation' => 'test1111',
            'c_name' => 'test_company',
            'last_name' => 'test',
            'first_name' => 'test',
            'phone1' => '080',
            'phone2' => '1111',
            'phone3' => '1111'
        ]);

        $response->assertStatus(302);

        $this->assertFalse(Auth::guard('employer')->check());

        $response = $this->from('employer/confirm')->post('employer/register', [
            'email' => 'test@test.com',
            'password' => 'test1111',
            'c_name' => 'test_company',
            'last_name' => 'test',
            'first_name' => 'test',
            'phone1' => '080',
            'phone2' => '1111',
            'phone3' => '1111',
            'status' => '0'
        ]);

        $this->assertDatabaseHas('employers', [
            // 'email' => 'test@test.com',
            // 'password' => 'test1111',
            // 'last_name' => 'test',
            // 'first_name' => 'test',
            // 'phone1' => '080',
            // 'phone2' => '1111',
            // 'phone3' => '1111',
            'status' => '0'
        ]);
        $this->assertDatabaseHas('companies', [
            'c_name' => 'test_company'
        ]);

        // $this->assertFalse(Auth::guard('employer')->check());

        // $response->assertStatus(302);
        // $response->assertRedirect('employer/register');

        // $response->assertSee('本登録はまだ終わっていません');


    }

}
