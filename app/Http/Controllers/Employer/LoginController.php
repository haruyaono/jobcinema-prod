<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $maxAttempts = 10;     // ログイン試行回数（回）
    protected $decayMinutes = 10;   // ログインロックタイム（分）

    
    protected $redirectTo = '/company/mypage';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:employer')->except('logout');
    }

    public function showLoginForm()
    {
        return view('employer.login');  //変更
    }


    protected function guard()
    {
        return Auth::guard('employer');  //変更
    }

    

    public function logout(Request $request)
    {
        $this->guard('employer')->logout();
        // $request->session()->flush();
        // $request->session()->regenerate();

        return redirect('employer/login'); // ここを好きな遷移先に変更する。
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('認証に失敗しました。')],
        ]);
    }
    
}
