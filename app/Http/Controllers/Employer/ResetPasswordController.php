<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/employer/redirect/passreset';

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

    public function redirectPassReset() {
        \Auth::guard('employer')->logout();
        return redirect('employer/login');
    }
}
