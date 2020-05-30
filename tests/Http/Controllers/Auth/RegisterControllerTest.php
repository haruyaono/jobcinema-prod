<?php

namespace Tests\Http\Controllers\Auth;

use Tests\TestCase;
use App\Job\Users\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;

class UserRegister extends TestCase
{

    /** @test */
    public function it_can_show_the_registration_page()
    {
        $this->get(route('register'))
            ->assertStatus(200)
            ->assertSee('無料新規会員登録')
            ->assertSee('メールアドレス')
            ->assertSee('パスワード')
            ->assertSee('確認用パスワード');
    }

    /** @test */
    public function it_can_register_the_user()
    {
        $data = [
            'email' => $this->faker->email,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];

        $response = $this->post(route('user.register.post'), $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
        $this->assertTrue(Auth::check());
        $response->assertRedirect(route('home'));
    }

     /** @test */
     public function it_throws_validation_error_during_registration()
     {
         $this->post(route('user.register.post'), [])
            ->assertStatus(302)
            ->assertSessionHasErrors();
     }

}
