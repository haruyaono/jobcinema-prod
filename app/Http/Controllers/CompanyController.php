<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\JobItem; 
use App\Models\Employer; 
use Storage;
use File; 
use Hash;
use Log;

class CompanyController extends Controller
{
    public function __construct()
    {
      $this->middleware(['employer'], ['except'=>array('index')]);
    }

    //mypage password change
    public function getChangePasswordForm() {
        return view('employer.passwords.changepassword');
    }
    public function postChangePassword(Request $request) {
        //現在のパスワードが正しいかを調べる
        if(!(Hash::check($request->get('current-password'), auth('employer')->user()->password))) {
            return redirect()->back()->with('change_password_error', '現在のパスワードが間違っています。');
        }

        //現在のパスワードと新しいパスワードが違っているかを調べる
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with('change_password_error', '新しいパスワードが現在のパスワードと同じです。違うパスワードを設定してください。');
        }

        //パスワードのバリデーション。新しいパスワードは6文字以上、new-password_confirmationフィールドの値と一致しているかどうか。
        $validated_data = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //パスワードを変更
        $employer = auth('employer')->user();
        $employer->password = bcrypt($request->get('new-password'));
        $employer->save();

        return redirect()->back()->with('change_password_success', 'パスワードを変更しました。');
    }

    //mypage email change
    public function getChangeEmail() {
        return view('employer.passwords.change_email');
    }
    public function postChangeEmail(Request $request) {
        $validated_data = $request->validate([
            'email' => 'required|email|string|max:191|unique:employers|unique:users',
        ]);

        $employer = auth('employer')->user();
        $employer->email = $request->get('email');
        $employer->save();

        return redirect()->back()->with('change_email_success', 'メールアドレスを変更しました。');
    }

    // public function index($id, Company $company)
    // {
    //     return view('companies.index', compact('company'));
    // }

    public function mypageIndex()
    {

        return view('companies.mypage');
    }

    public function create()
    {

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

        $employer_id = auth('employer')->user()->id;
        $company = Company::where('employer_id',$employer_id)->first();
        

        $postcode = $company['postcode'];
        $postcode = str_replace("-", "", $postcode);
        $postcode1 = substr($postcode,0,3);
        $postcode2 = substr($postcode,3);

        $foundation = $company['foundation'];
        $foundation = str_replace(array('年', '月'), "", $foundation);
        $foundation1 = substr($foundation,0,4);
        $foundation2 = substr($foundation,4);


        return view('companies.create', compact('industries', 'employeeNumbers', 'postcode1', 'postcode2', 'foundation1', 'foundation2'));
    }

    public function mypageStore(Request $request)
    {
        $this->validate($request,[
            'cname' => 'required|string|max:191',
            'cname_katakana' => 'required|string|max:191|katakana',
            'zip31' => 'required|numeric|digits:3',
            'zip32' => 'required|numeric|digits:4',
            'pref31' => 'required|string|max:191',
            'addr31' => 'required|string|max:191',
            'ceo' => 'max:191',
            'f_year' => 'required|numeric|digits:4',
            'f_month' => 'required',
            'capital' => 'max:191',
            'industry' => 'required',
            'description' => 'required|string|max:400',
            'employee_number' => 'required',
            'website' => 'max:191',
            'c_phone1' => 'required|numeric|digits_between:2,5',
            'c_phone2' => 'required|numeric|digits_between:1,4',
            'c_phone3' => 'required|numeric|digits_between:3,4',
        ]);

        $postal_code = $request->zip31."-".$request->zip32;
        $foundation = $request->f_year." 年 ".$request->f_month." 月";
        
        $employer_id = auth('employer')->user()->id;
        Company::where('employer_id',$employer_id)->update([

            'cname' => request('cname'),
            'slug' => $employer_id,
            'cname_katakana' => request('cname_katakana'),
            'postcode' => $postal_code,
            'prefecture' => request('pref31'),
            'address' => request('addr31'),
            'ceo' => request('ceo'),
            'foundation' => $foundation,
            'capital' => request('capital'),
            'industry' => request('industry'),
            'description' => request('description'),
            'employee_number' => request('employee_number'),
            'website' => request('website'),
            'phone1' => request('c_phone1'),
            'phone2' => request('c_phone2'),
            'phone3' => request('c_phone3'),
            
        ]);
        return redirect()->back()->with('message_success','企業データを更新しました');
    }

     public function companyLogo(Request $request)
     {
        $this->validate($request,[
            'logo' => 'required | max:20000',

        ]);
        $employer_id = auth('employer')->user()->id;
        if($request->hasfile('logo')) {
            $file = $request->file('logo');
            $ext = $file->getClientOriginalExtension(); 
            $filename = time(). '.' .$ext;
            $file->move('upload/c_logo/', $filename);
    
            $contents = File::get(public_path().'/upload/c_logo/'.$filename);
            Storage::disk('s3')->put('upload/c_logo/'.$filename, $contents, 'public');
            Company::where('employer_id', $employer_id)->update([
                'logo' => 'upload/c_logo/'.$filename,
            ]);
            return redirect()->back()->with('message_success','企業ロゴを登録しました');
        } else {
            return redirect()->back()->with('message_danger','画像を選択してください');
        }
     }

     public function companyLogoDelete(Request $request)
    {
        $employer = Employer::find(auth('employer')->user()->id);
        $employer_id = auth('employer')->user()->id;
        if (is_null($employer->company->logo)) {
            return redirect()->back()->with('message_danger', '削除するロゴがありません');
        }
        Storage::disk('s3')->delete($employer->company->logo);
        File::delete(public_path().'/'.$employer->company->logo);
        Company::where('employer_id', $employer_id)->update([
            'logo' => null,
        ]);
        return redirect()->back()->with('message_success', 'ロゴを削除しました');
    }

    public function companyDeleteApp()
    {
        $employer = Employer::find(auth('employer')->user()->id);
        $employer->update([
            'status' => 8,
        ]);

        return redirect()->back()->with('message_success', 'アカウント削除申請をしました');
 
    }

    public function companyDeleteAppCancel()
    {
        $employer = Employer::find(auth('employer')->user()->id);
        $employer->update([
            'status' => 1,
        ]);

        return redirect()->back()->with('message_success', 'アカウント削除申請を取り消しました');
 
    }
}
