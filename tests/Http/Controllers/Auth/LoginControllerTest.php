<?php

namespace Tests\Http\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;

class UserLogin extends TestCase
{


    /** @test */
    public function user_can_view_login()
    {
        $response = $this->get('/members/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function unauthenticated_user_cannot_view_home()
    {
        $response = $this->get('mypage/index');
        $response->assertRedirect('members/login');
    }

    /** @test */
    public function valid_user_can_login()
    {
        $user = factory(User::class)->create([
            'password'  => bcrypt('test1111')
        ]);
    
        $this->assertFalse(Auth::check());
    
        $response = $this->post('members/login', [
            'email'    => $user->email,
            'password' => 'test1111'
        ]);
    
        $this->assertTrue(Auth::check());
    
        $response->assertRedirect('mypage/index');
    }

    /** @test */
    public function invalid_user_cannot_login()
    {
        $user = factory(User::class)->create([
            'password'  => bcrypt('test1111')
        ]);
    
        $this->assertFalse(Auth::check());
    
        $response = $this->post('members/login', [
            'email'    => $user->email,
            'password' => 'test2222'
        ]);
    
        $this->assertFalse(Auth::check());

        $response->assertSessionHasErrors(['email']);
    
        $this->assertEquals('認証に失敗しました。',
            session('errors')->first('email'));
        }

        /** @test */
        public function logout()
        {
            $user = factory(User::class)->create();
            $this->actingAs($user);
            $this->assertTrue(Auth::check());
            $response = $this->post('members/logout');
            $this->assertFalse(Auth::check());
            $response->assertRedirect('members/logout');
        }


}
