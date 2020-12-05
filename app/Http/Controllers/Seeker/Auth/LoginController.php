<?php

namespace App\Http\Controllers\Seeker\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Providers\RouteServiceProvider;

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

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:seeker')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('seeker');
    }

    public function showLoginForm()
    {
        return view('seeker.auth.login');
    }

    public function logout(Request $request)
    {
        $this->guard('seeker')->logout();
        return redirect(route('seeker.login'));
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('認証に失敗しました。')],
        ]);
    }

    protected function authenticated(Request $request)
    {
        if ($request->input('redirect_to')) {
            return redirect($request->input('redirect_to'));
        }
        return redirect()->intended($this->redirectPath());
    }
}
