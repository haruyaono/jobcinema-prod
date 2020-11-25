<?php

namespace App\Http\Controllers\Employer\Auth;

use Carbon\Carbon;
use App\Models\Employer;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\Front\Employer\EmpPreRegisterRequest;
use App\Http\Requests\Front\Employer\EmpMainRegisterRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect employer after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::EMPLOYER_HOME;

    public function index()
    {
        return view('employer.auth.register');
    }

    public function confirm(EmpPreRegisterRequest $request)
    {
        $data = $request->input('company_form');
        unset($data['password_confirmation']);

        $data['password_mask'] = '******';
        $request->session()->put('company_form', $data);

        return view('employer.auth.confirm');
    }

    public function register(Request $request)
    {
        if (Employer::where('email', $request->email)->exists() || $request->session()->has('company_form') == false) {
            return redirect()->route('employer.register.index');
        }

        $data = $request->session()->get('company_form');
        $cname = $data['cname'];

        unset($data['cname'], $data['password_mask']);

        $employer = DB::transaction(function () use ($cname, $data) {

            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            if (isset($data['email'])) {
                $data['email_verify_token'] = base64_encode($data['email']);
            }

            $employer = Employer::create($data);

            $cData = [
                'employer_id' => $employer->id,
                'cname' => $cname,
            ];

            Company::create($cData);

            return $employer;
        });

        $request->session()->forget('company_form');

        $email = new EmailVerification($employer);
        Mail::to($employer->email)->queue($email);

        event(new Registered($employer));

        return redirect()->route('employer.pre_register.finish');
    }

    public function finishRegister()
    {
        return view('employer.auth.registered');
    }

    public function showForm($email_token)
    {
        // 使用可能なトークンか
        if (!Employer::where('email_verify_token', $email_token)->exists()) {
            return view('employer.auth.main.register')->with('message', '無効なトークンです。');
        }

        $employer = Employer::where('email_verify_token', $email_token)->first();
        // 本登録済みユーザーか
        if ($employer->status == config('const.EMPLOYER_STATUS.REGISTER') || $employer->status == config('const.EMPLOYER_STATUS.PRE_DEACTIVE') || $employer->status == config('const.EMPLOYER_STATUS.DEACTIVE')) {
            return view('employer.auth.main.register')->with('message', 'すでに本登録されています。 ログインして利用してください。');
        }
        // メール認証ステータス更新
        $updated = $employer->update([
            'email_verified' => config('const.EMPLOYER_STATUS.MAIL_AUTHED'),
            'email_verified_at' => Carbon::now()
        ]);

        if ($updated) {

            $industries = config('const.INDUSTORIES');
            $employeeNumbers = config('const.EMPLOYEE_NUMBERS');

            return view('employer.auth.main.register', compact('employer', 'industries', 'employeeNumbers', 'email_token'));
        } else {
            return view('employer.auth.main.register')->with('message', 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。');
        }
    }

    public function mainRegister(EmpMainRegisterRequest $request)
    {
        $employer = Employer::where('email_verify_token', $request->email_token)->first();
        $company = $employer->company;

        if ($employer->status == config('const.EMPLOYER_STATUS.REGISTER')) {
            return view('employer.auth.main.register')->with('message', 'すでに本登録されています。
       ログインして利用してください。');
        }

        DB::transaction(function () use ($employer, $company, $request) {

            $eData = $request->input('company_form.employer');
            $eData['status'] = config('const.EMPLOYER_STATUS.REGISTER');

            $employer->update($eData);

            $cData = $request->input('company_form.company');
            $cData['postcode'] =  $cData['postcode01'] . "-" .  $cData['postcode02'];
            $cData['foundation'] =  $cData['f_year'] . " 年 " . $cData['f_month'] . " 月";

            unset($cData['postcode01'], $cData['postcode02'], $cData['f_year'], $cData['f_month']);

            $company->update($cData);
        });

        return redirect()->route('employer.main_register.finish');
    }

    public function finishMainRegister()
    {
        return view('employer.auth.main.registered');
    }

    // 確認メール再送画面
    public function getVerifyResend()
    {
        return view('employer.auth.verify_resend');
    }

    //確認メール再送
    public function postVerifyResend(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        $employer = Employer::where('email', $request->input('email'))->first();
        if (!$employer) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans('「メールアドレス」は存在しません')]);
        }
        if ($employer->isMainRegistered()) {
            \Session::flash('flash_message_danger', nl2br('既に、本登録が完了しています。ログインしてください。'));
            return redirect(route('employer.login'));
        }

        $email = new EmailVerification($employer);
        Mail::to($employer->email)->queue($email);

        \Session::flash('flash_message_success', $employer->email . 'に再送いたしました。');
        return redirect()->guest(route('employer.login'));
    }
}
