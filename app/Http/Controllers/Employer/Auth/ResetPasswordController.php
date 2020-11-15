<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/employer/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:employer');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('employer.passwords.reset')->with(['token' => $token, 'email' => $request->email]);
    }

    protected function guard()
    {
        return \Auth::guard('employer');
    }

    public function broker()
    {
        return \Password::broker('employers');
    }

    protected function resetPassword($user, $password)
    {

        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        if ($user->isMainRegistered()) {
            $this->guard()->login($user);
        }
    }
}
