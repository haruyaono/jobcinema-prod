<?php

namespace App\Http\Controllers\Seeker\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:seeker');
    }

    protected function guard()
    {
        return \Auth::guard('seeker');
    }

    public function broker()
    {
        return \Password::broker('seekers');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('seeker.auth.passwords.reset')->with(['token' => $token, 'email' => $request->email]);
    }
}
