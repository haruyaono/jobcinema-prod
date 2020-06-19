<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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

    protected $redirectTo = '/dashboard/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');  //変更
    }

    public function logout(Request $request)
    {
        $this->guard('admin')->logout();
        // $request->session()->flush();
        // $request->session()->regenerate();
        return redirect()->to('/dashboard/login'); 
    }

    // protected function sendFailedLoginResponse(Request $request)
    // {
    //     throw ValidationException::withMessages([
    //         $this->username() => [trans('認証に失敗しました。')],
    //     ]);
    // }

    public function username()
{
    return 'name';
}
    
}
