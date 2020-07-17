<?php

namespace Tests\Http\Controllers\Auth;

use Tests\TestCase;
use App\Job\Users\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;
use Hash;

class UserResetPassword extends TestCase
{

    // use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        Notification::fake();
    }
    
    /** @test */
    public function it_can_show_the_reset_request_password_page()
    {
        $response = $this->get(route('password.request'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_request_reset_by_valid_user()
    {
        $user = factory(User::class)->create();
        $response = $this->from(route('password.request'))->post(route('password.email'), [
            'email' => $this->user->email,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('password.request'));
        $response->assertSessionHas('status', 
            'パスワード再設定用のURLをメールで送りました。');
    }

    /** @test */
    public function it_errors_when_invalid_user_is_requesting_reset()
    {

        $response = $this->from('members/password/reset')->post('members/password/email', [
            'email' => 'nobody@example.com'
        ]);
    
        $response->assertStatus(302);
        $response->assertRedirect(route('password.request'));
    
        $response->assertSessionHasErrors('email',
            'メールアドレスに一致するユーザーが存在しません。');
    }

     /** @test */
    public function it_can_show_the_reset_password_page()
    {
        $this->get(route('password.reset', $this->faker->uuid))
            ->assertStatus(200);
    }

    /** @test */
    // public function it_can_request_password_by_valid_user()
    // {

    //     Notification::fake();

    //     $user = factory(User::class)->create();
    //     $user->save();
    //     $response = $this->post(route('password.email'), [
    //         'email' => $user->email,
    //     ]);

    //     $token = '';

    //     Notification::assertSentTo(
    //         $user,
    //         ResetPassword::class,
    //         function ($notification, $channels) use ($user, &$token) {
    //             $token = $notification->token;
    //             return true;
    //         }

    //     );

    //     $response = $this->get(route('password.reset'), ['token' => $token]);
    //     $response->assertStatus(200);

    //     $new = 'reset1111';

    //     $response = $this->post(route('password.update'), [
    //         'email' => $user->email,
    //         'token' => $token,
    //         'password' => $new,
    //         'password_confirmation' => $new
    //     ]);

    //     $response->assertStatus(302);
    //     $response->assertRedirect(route('mypages.index'));

    //     $this->assertTrue(Auth::check());

    //     $this->assertTrue(Hash::check($new, $user->fresh()->password));
    // }


}
