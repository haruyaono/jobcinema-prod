<?php

namespace App\Http\Controllers\Employer;

use App\Job\Employers\Employer;
use App\Job\Employers\Repositories\EmployerRepository;
use App\Job\Employers\Repositories\Interfaces\EmployerRepositoryInterface;
use App\Job\Companies\Repositories\CompanyRepository;
use App\Job\Companies\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests\EmpPreRegisterRequest;
use App\Http\Requests\EmpMainRegisterRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * @var EmployerRepositoryInterface
     * @var CompanyRepositoryInterface
     */
    private $employerRepo;
    private $companyRepo;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/company/mypage';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        EmployerRepositoryInterface $employerRepository,
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->employerRepo = $employerRepository;
        $this->companyRepo = $companyRepository;
    }

    public function index()
    {
        return view('employer.register');
    }

    public function confirm(EmpPreRegisterRequest $request)
    {

        $data = $request->except('_method', '_token');
        $data['password_mask'] = '******';
        $request->session()->put('setdata', $data);

        return view('employer.confirm')->with($data);
    }

    public function register(Request $request)
    {
        if (!Employer::where('email', $request->email)->exists()) {

            $eData = [
                'email' => $request->email,
                'password' => $request->password,
                'last_name' => $request->e_last_name,
                'first_name' => $request->e_first_name,
                'phone1' => $request->e_phone1,
                'phone2' => $request->e_phone2,
                'phone3' => $request->e_phone3,
            ];
            $employer = $this->employerRepo->createEmployer($eData);

            $cData = [
                'employer_id' => $employer->id,
                'cname' => request('cname'),
            ];

            $this->companyRepo->createCompany($cData);

            $request->session()->forget('setdata');

            $email = new EmailVerification($employer);
            Mail::to($employer->email)->queue($email);

            event(new Registered($employer));

            return view('employer.registered');
        } else {
            return redirect()->route('employer.register.index');
        }
    }

    public function showForm($email_token)
    {
        // 使用可能なトークンか
        if (!Employer::where('email_verify_token', $email_token)->exists()) {
            return view('employer.main.register')->with('message', '無効なトークンです。');
        } else {

            $employer = Employer::where('email_verify_token', $email_token)->first();
            // 本登録済みユーザーか
            if ($employer->status == config('const.EMPLOYER_STATUS.REGISTER') || $employer->status == config('const.EMPLOYER_STATUS.PRE_DEACTIVE') || $employer->status == config('const.EMPLOYER_STATUS.DEACTIVE')) {
                logger("status" . $employer->status);
                return view('employer.main.register')->with('message', 'すでに本登録されています。 ログインして利用してください。');
            }
            // メール認証ステータス更新
            $employerRepo = new EmployerRepository($employer);
            $updated = $employerRepo->updateEmployer([
                'email_verified' => config('const.EMPLOYER_STATUS.MAIL_AUTHED'),
                'email_verified_at' => Carbon::now()
            ]);

            if ($updated) {

                $industries = config('const.INDUSTORIES');
                $employeeNumbers = config('const.EMPLOYEE_NUMBERS');

                return view('employer.main.register', compact('employer', 'industries', 'employeeNumbers', 'email_token'));
            } else {
                return view('employer.main.register')->with('message', 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。');
            }
        }
    }

    public function mainRegister(EmpMainRegisterRequest $request)
    {

        $employer = Employer::where('email_verify_token', $request->email_token)->first();
        $company = $employer->company;

        if ($employer->status == config('const.EMPLOYER_STATUS.REGISTER')) {
            logger("status" . $employer->status);
            return view('employer.main.register')->with('message', 'すでに本登録されています。
       ログインして利用してください。');
        }

        $empReqData = [
            'last_name' => $request->e_last_name,
            'first_name' => $request->e_first_name,
            'last_name_katakana' => $request->e_last_name_katakana,
            'first_name_katakana' => $request->e_first_name_katakana,
            'status' => config('const.EMPLOYER_STATUS.REGISTER'),
            'phone1' => $request->e_phone1,
            'phone2' => $request->e_phone2,
            'phone3' => $request->e_phone3,
        ];

        $employerRepo = new EmployerRepository($employer);
        $employerRepo->updateEmployer($empReqData);

        $comReqData = [
            'cname' => $request->cname,
            'cname_katakana' => $request->cname_katakana,
            'postcode' => $request->zip31 . "-" . $request->zip32,
            'prefecture' => $request->pref31,
            'address' => $request->addr31,
            'foundation' => $request->f_year . " 年 " . $request->f_month . " 月",
            'ceo' => $request->ceo,
            'capital' => $request->capital,
            'industry' => $request->industry,
            'description' => $request->description,
            'employee_number' => $request->employee_number,
            'website' => $request->website,
            'phone1' => $request->c_phone1,
            'phone2' => $request->c_phone2,
            'phone3' => $request->c_phone3,
        ];

        $companyRepo = new CompanyRepository($company);
        $companyRepo->updateCompany($comReqData);

        return view('employer.main.registered');
    }

    // 確認メール再送画面
    public function getVerifyResend()
    {
        return view('employer.verify_resend');
    }

    //確認メールの再送信する
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
            return redirect('employer/login');
        }

        $email = new EmailVerification($employer);
        Mail::to($employer->email)->queue($email);

        \Session::flash('flash_message_success', $employer->email . 'に再送いたしました。');
        return redirect()->guest('employer/login');
    }
}
