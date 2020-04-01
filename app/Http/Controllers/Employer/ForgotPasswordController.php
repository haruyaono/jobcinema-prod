<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:employer');
    }

    public function showLinkRequestForm()
    {
       return view('employer.passwords.email');
    }

    protected function guard()
    {
        return \Auth::guard('employer');
    }

    public function broker()
    {
        return \Password::broker('employers');
    }
}
