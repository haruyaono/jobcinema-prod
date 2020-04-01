<?php

namespace Tests\Http\Controllers\Employer;

use Tests\TestCase;
use App\Models\Employer;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;
use Hash;

class EmployerResetPassword extends TestCase
{

    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        Notification::fake();
    }
    
    /** @test */
    public function test_employer_can_view_reset_request()
    {
        $response = $this->get('employer/password/reset');
        $response->assertStatus(200);
    }

    /** @test */
    public function valid_employer_can_request_reset()
    {
        $employer = factory(Employer::class)->create();
        $response = $this->from('employer/password/reset')->post('employer/password/email', [
            'email' => $employer->email,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('employer/password/reset');

        $response->assertSessionHas('status', 
            'パスワード再設定用のURLをメールで送りました。');
    }

    /** @test */
    public function invalid_employer_cannot_request_reset()
    {
        $employer = factory(Employer::class)->create();

        $response = $this->from('employer/password/reset')->post('employer/password/email', [
            'email' => 'nobody@example.com'
        ]);
    
        $response->assertStatus(302);
        $response->assertRedirect('employer/password/reset');
    
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
