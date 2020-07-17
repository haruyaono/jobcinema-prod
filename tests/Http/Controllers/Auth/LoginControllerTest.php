<?php

namespace Tests\Http\Controllers\Auth;

use Tests\TestCase;
use App\Job\Users\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;

class UserLogin extends TestCase
{

      /** @test */
      public function it_can_show_the_user_account()
      {
          $this->actingAs($this->user, 'user')
              ->get(route('mypages.index'))
              ->assertStatus(200);
      }
  

    /** @test */
    public function it_shows_the_login_form()
    {
        $this->get(route('login'))
            ->assertStatus(200)
            ->assertSee('求職者ログイン')
            ->assertSee('メールアドレス')
            ->assertSee('パスワード')
            ->assertSee('パスワードを忘れた方')
            ->assertSee('次回から自動ログインする')
            ->assertSee('無料会員登録はこちら');
    }

    /** @test */
    public function it_shows_the_account_page_after_successful_login()
    {
        $this
            ->post(route('login.post'), ['email' => $this->user->email, 'password' => 'secret'])
            ->assertStatus(302)
            ->assertRedirect(route('mypages.index'));
    }

    /** @test */
    public function it_throws_the_too_many_login_attempts_event()
    {
        $this->expectsEvents(Lockout::class);

        $user = factory(User::class)->create();

        for ($i=0; $i <= 11; $i++) {
            $data = [
                'email' => $user->email,
                'password' => 'unknown'
            ];

            $this->post(route('login.post'), $data);
        }
    }

  

    /** @test */
    public function it_ridirects_whrn_unauthenticated_user_go_to_user_cannot_view_home()
    {
        $response = $this->get(route('mypages.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function it_can_go_to_my_accounts_page_on_successful_login()
    {
        $user = factory(User::class)->create();

        $data = [
            'email' => $user->email,
            'password' => 'secret'
        ];
    
        $this->assertFalse(Auth::check());
    
        $response = $this->post(route('login.post'), $data);
    
        $this->assertTrue(Auth::check());
    
        $response->assertRedirect(route('mypages.index'));
    }

    /** @test */
    public function it_errors_when_the_user_is_logging_in_without_the_email_or_password()
    {
    
        $this->assertFalse(Auth::check());

        $response = $this->post(route('login.post'), ['email' => $this->user->email, 'password' => 'test2222']);
    
        $this->assertFalse(Auth::check());

        $response->assertSessionHasErrors(['email']);
    
        $this->assertEquals('認証に失敗しました。',
            session('errors')->first('email'));
    }

    /** @test */
    public function logout()
    {
        $this->actingAs($this->user);
        $this->assertTrue(Auth::check());
        $response = $this->post(route('logout'));
        $this->assertFalse(Auth::check());
        $response->assertRedirect(route('user.logout.cpl'));
    }


}
