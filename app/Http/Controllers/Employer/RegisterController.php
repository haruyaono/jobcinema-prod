<?php

namespace App\Http\Controllers\Employer;

use App\Models\Employer;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests\EmpPreRegisterRequest;
use App\Http\Requests\EmpMainRegisterRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use Auth;

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
    public function __construct()
    {
        $this->middleware(['guest:employer']);
    }

    public function index()
    {
        if(url()->previous() !== "http://jobcinema/employer/confirm"){
            session()->forget('setdata');
        }
        return view('employer.register');
    }
    
    public function confirm(EmpPreRegisterRequest $request)
    {
        $request->session()->forget('count');
        $data = $request->all();
        $data['password_mask'] = '******';
        $request->session()->put('setdata', $data);
        
        return view('employer.confirm')->with($data);

    }

    public function register(Request $request)
    {
        if ( !Employer::where('email',request('email'))->exists() )
        {
            $employer = Employer::create([

                'email' => request('email'),
                'password' => Hash::make(request('password')),
                'last_name' => request('e_last_name'),
                'first_name' => request('e_first_name'),
                'phone1' => request('e_phone1'),
                'phone2' => request('e_phone2'),
                'phone3' => request('e_phone3'),
                'email_verify_token' => base64_encode(request('email')),
            ]);

            Company::create([
                'employer_id' => $employerId = $employer->id,
                'cname' => request('cname'),
                'slug' => str_slug($employerId),
            ]);
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
        if ( !Employer::where('email_verify_token',$email_token)->exists() )
        {
            return view('employer.main.register')->with('message', '無効なトークンです。');
        } else {
            
            $employer = Employer::where('email_verify_token', $email_token)->first();
            // 本登録済みユーザーか
            if ($employer->status == config('const.EMPLOYER_STATUS.REGISTER') || $employer->status == config('const.EMPLOYER_STATUS.PRE_DEACTIVE') || $employer->status == config('const.EMPLOYER_STATUS.DEACTIVE')) 
            {
                logger("status". $employer->status );
                return view('employer.main.register')->with('message', 'すでに本登録されています。 ログインして利用してください。');
            }
            // メール認証ステータス更新
            $employer->email_verified = config('const.EMPLOYER_STATUS.MAIL_AUTHED');
            $employer->email_verified_at = Carbon::now();
            if($employer->save()) {

                $industries = [
                    'IT・通信','インターネット・広告・メディア','メーカー（機械・電気','メーカー（素材・化学・食品・化粧品・その他）',
                    '商社','医薬品・医療機器・ライフサイエンス・医療系サービス','金融','建設・プラント・不動産',
                    'コンサルティング・専門事務所・監査法人・税理士法人・リサーチ','人材サービス・アウトソーシング・コールセンター','小売','外食',
                    '運輸・物流','エネルギー（電力・ガス・石油・新エネルギー）','旅行・宿泊・レジャー','警備・清掃','理容・美容・エステ',
                    '教育', '農林水産・鉱業', '公社・官公庁・学校・研究施設', '公社・官公庁・学校・研究施設', 'その他', 
                ];
                $employeeNumbers= [
                    '1〜10人','11〜50人','51〜100人','101〜300人','301〜500人','501〜1000人','1001〜5000人','5001〜10000人','10001以上',
                ];
                return view('employer.main.register', compact('employer','industries','employeeNumbers','email_token'));
            } else{
                return view('employer.main.register')->with('message', 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。');
            }
        }
    }


//     public function mainConfirm(Request $request)
//   {
//     $request->validate([
//       'cname' => 'required|string',
//       'ceo' => 'required|string',
//     ]);
//     $email_token = $request->email_token;

//     $employer = new Employer();
//     $employer->last_name = $request->last_name;
//     $employer->first_name = $request->first_name;

//     $company = new Company();
//     $company->cname = $request->cname;
//     $company->ceo = $request->ceo;
    

//     return view('employer.main.confirm', compact('employer','company','email_token'));
//   }

  public function mainRegister(EmpMainRegisterRequest $request)
  {
    
    $employer = Employer::where('email_verify_token',$request->email_token)->first();
    if ($employer->status == config('const.EMPLOYER_STATUS.REGISTER')) {
        logger("status". $employer->status );
       return view('employer.main.register')->with('message', 'すでに本登録されています。
       ログインして利用してください。');
    }
    $employer->status = config('const.EMPLOYER_STATUS.REGISTER');
    $employer->last_name = $request->e_last_name;
    $employer->first_name = $request->e_first_name;
    $employer->last_name_katakana = $request->e_last_name_katakana;
    $employer->first_name_katakana = $request->e_first_name_katakana;
    $employer->phone1 = $request->e_phone1;
    $employer->phone2 = $request->e_phone2;
    $employer->phone3 = $request->e_phone3;
    $employer->save();

    $postal_code = $request->zip31."-".$request->zip32;
    $foundation = $request->f_year." 年 ".$request->f_month." 月";

    $company = $employer->company;
    $company->cname = $request->cname;
    $company->cname_katakana = $request->cname_katakana;
    $company->postcode = $postal_code;
    $company->prefecture = $request->pref31;
    $company->address = $request->addr31;
    $company->foundation = $foundation;
    $company->ceo = $request->ceo;
    $company->capital = $request->capital;
    $company->industry = $request->industry;
    $company->description = $request->description;
    $company->employee_number = $request->employee_number;
    $company->website = $request->website;
    $company->phone1 = $request->c_phone1;
    $company->phone2 = $request->c_phone2;
    $company->phone3 = $request->c_phone3;
    $employer->company()->save($company);

    //ユーザーステータスの更新
    $employer->status = config('const.EMPLOYER_STATUS.REGISTER');

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
    $employer = Employer::where('email', '=', $request->input('email'))->first();
    if(!$employer) {
            return redirect()->back()
        ->withInput($request->only('email'))
        ->withErrors(['email' => trans('「メールアドレス」は存在しません')]);
    }
    if($employer->isMainRegistered()) {
        \Session::flash('flash_message_danger', nl2br('既に、本登録が完了しています。ログインしてください。'));
        return redirect('employer/login');
    }


     $email = new EmailVerification($employer);
     Mail::to($employer->email)->queue($email);

    \Session::flash('flash_message_success', $employer->email.'に再送いたしました。');
    return redirect()->guest('employer/login');
    }
  
}
