<?php

namespace App\Http\Controllers\Seeker\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

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

    public function showLinkRequestForm()
    {
        return view('seeker.auth.passwords.email');
    }
}
