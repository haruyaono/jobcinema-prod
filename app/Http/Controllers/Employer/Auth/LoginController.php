<?php

namespace App\Http\Controllers\Employer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $maxAttempts = 10;     // ログイン試行回数（回）
    protected $decayMinutes = 10;   // ログインロックタイム（分）


    protected $redirectTo = RouteServiceProvider::EMPLOYER_HOME;

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

    protected function guard()
    {
        return Auth::guard('employer');
    }

    public function showLoginForm()
    {
        return view('employer.auth.login');
    }

    public function logout(Request $request)
    {
        $this->guard('employer')->logout();
        return redirect(route('employer.login'));
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
            return redirect()->intended(RouteServiceProvider::EMPLOYER_HOME);
        }
    }
}
