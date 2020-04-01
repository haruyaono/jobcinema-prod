<?php

namespace Tests\Http\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;

class UserRegister extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function user_can_view_register()
    {
        $response = $this->get('/members/register');
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_register()
    {
        $response = $this->from('members/register')->post('members/register', [
            'email' => 'test@test.com',
            'password' => 'test1111',
            'password_confirmation' => 'test1111'
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com'
        ]);

        $this->assertTrue(Auth::check());
        
        $response->assertStatus(302);
        $response->assertRedirect('members/register_complete');

    }


}
