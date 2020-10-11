<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Job\Employers\Employer;

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
        $this->middleware('confirm:employer');
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

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('employer')->attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('company/mypage');
        }
    }

    // protected function attemptLogin(Request $request)
    // {
    //     $credentials = $this->credentials($request);
    //     $credentials['status'] = 1;

    //     return $this->guard()->attempt(
    //         $credentials,
    //         $request->filled('remember')
    //     );
    // }
}
