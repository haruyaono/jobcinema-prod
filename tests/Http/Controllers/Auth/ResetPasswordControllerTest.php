<?php

namespace Tests\Http\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
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
    public function test_user_can_view_reset_request()
    {
        $response = $this->get('/members/password/reset');
        $response->assertStatus(200);
    }

    /** @test */
    public function valid_user_can_request_reset()
    {
        $user = factory(User::class)->create();
        $response = $this->from('members/password/reset')->post('members/password/email', [
            'email' => $user->email,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('members/password/reset');

        $response->assertSessionHas('status', 
            'パスワード再設定用のURLをメールで送りました。');
    }

    /** @test */
    public function invalid_user_cannot_request_reset()
    {
        $user = factory(User::class)->create();

        $response = $this->from('members/password/reset')->post('members/password/email', [
            'email' => 'nobody@example.com'
        ]);
    
        $response->assertStatus(302);
        $response->assertRedirect('members/password/reset');
    
        $response->assertSessionHasErrors('email',
            'メールアドレスに一致するユーザーが存在しません。');
    }

    /** @test */
    // public function valid_user_can_request_password()
    // {

    //     $user = factory(User::class)->create();
    //     $user->save();
    //     $response = $this->post('members/password/email', [
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

    //     $response = $this->get('members/password/reset/'.$token);
    //     $response->assertStatus(200);

    //     $new = 'reset1111';

    //     $response = $this->post('members/password/reset', [
    //         'email' => $user->email,
    //         'token' => $token,
    //         'password' => $new,
    //         'password_confirmation' => $new
    //     ]);

    //     $response->assertStatus(302);
    //     $response->assertRedirect('mypage/index');

    //     $this->assertTrue(Auth::check());

    //     $this->assertTrue(Hash::check($new, $user->fresh()->password));
    // }


}
