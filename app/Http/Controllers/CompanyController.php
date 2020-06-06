<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job\Companies\Company;
use App\Job\Companies\Repositories\CompanyRepository;
use App\Job\Companies\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Job\Companies\Requests\UpdateCompanyRequest;
use App\Job\JobItems\JobItem; 
use App\Models\Employer; 
use App\Job\Employers\Repositories\EmployerRepository;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
     /**
    *  @var CompanyRepositoryInterface
     */
    private $companyRepo;

    /**
     * JobController constructor.
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(
        CompanyRepositoryInterface $companyRepository
    ){
        $this->companyRepo = $companyRepository;
    }

    //mypage password change
    public function getChangePasswordForm() 
    {
        return view('employer.passwords.changepassword');
    }

    public function postChangePassword(Request $request) 
    {
        $employer = auth('employer')->user();
        $employerRepo = new EmployerRepository($employer);

        //現在のパスワードが正しいかを調べる
        if(!(Hash::check($request->get('current-password'), $employer->password))) {
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
        $data = [
            'password' => bcrypt($request->get('new-password'))
        ];
        $employerRepo->updateEmployer($data);

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
        $employerRepo = new EmployerRepository($employer);

        $data = [
            'email' => $request->get('email')
        ];
        $employerRepo->updateEmployer($data);

        return redirect()->back()->with('change_email_success', 'メールアドレスを変更しました。');
    }

    public function mypageIndex()
    {
        return view('companies.mypage');
    }

    public function edit()
    {

        $industries = config('const.INDUSTORIES');
        $employeeNumbers = config('const.EMPLOYEE_NUMBERS');

        $employer = auth('employer')->user();
        $company = $employer->company;

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

    public function update(UpdateCompanyRequest $request)
    {
        
        $employer = auth('employer')->user();
        $company = $employer->company;

        $companyRepo = new CompanyRepository($company);

        $data = [
            'cname' => $request->cname,
            'cname_katakana' => $request->cname_katakana,
            'postcode' => $request->zip31."-".$request->zip32,
            'prefecture' => $request->pref31,
            'address' => $request->addr31,
            'ceo' => $request->ceo,
            'foundation' => $request->f_year." 年 ".$request->f_month." 月",
            'capital' => $request->capital,
            'industry' => $request->industry,
            'description' => $request->description,
            'employee_number' => $request->employee_number,
            'website' => $request->website,
            'phone1' => $request->c_phone1,
            'phone2' => $request->c_phone2,
            'phone3' => $request->c_phone3,
        ];

        $companyRepo->updateCompany($data);

        return redirect()->back()->with('message_success','企業データを更新しました');
    }

     public function companyLogo(Request $request)
     {
        $this->validate($request,[
            'logo' => 'required | max:20000',
        ]);

        $employer = auth('employer')->user();
        $company = $employer->company;
        $companyRepo = new CompanyRepository($company);

        if(!is_null($company->logo)) {
            Storage::disk('s3')->delete($company->logo);
            File::delete(public_path().'/'.$company->logo);
        }

        if($request->hasfile('logo')) {
            $file = $request->file('logo');
            $ext = $file->getClientOriginalExtension(); 
            $filename = time(). '.' .$ext;

            $filePath = 'upload/c_logo/'.$company->id .'/';
            
            $file->move($filePath, $filename);

            $contents = File::get(public_path().'/' . $filePath . $filename);
            Storage::disk('s3')->put($filePath . $filename, $contents, 'public');
               
            $companyRepo->updateCompany(['logo' => $filePath . $filename]);
        
            return redirect()->back()->with('message_success','企業ロゴを登録しました');
        } else {
            return redirect()->back()->with('message_danger','画像を選択してください');
        }
     }

     public function companyLogoDelete(Request $request)
    {
        $employer = auth('employer')->user();
        $company = $employer->company;
        $companyRepo = new CompanyRepository($company);

        if (is_null($company->logo)) {
            return redirect()->back()->with('message_danger', '削除するロゴがありません');
        }

        Storage::disk('s3')->delete($company->logo);
        File::delete(public_path().'/'.$company->logo);

        $companyRepo->updateCompany(['logo' => null]);
    
        return redirect()->back()->with('message_success', 'ロゴを削除しました');
    }

    public function companyDeleteApp()
    {
        $employer = auth('employer')->user();
        $employerRepo = new EmployerRepository($employer);

        $employerRepo->updateEmployer([
            'status' => 8
        ]);

        return redirect()->back()->with('message_success', 'アカウント削除申請をしました');
    }

    public function companyDeleteAppCancel()
    {
        $employer = auth('employer')->user();
        $employerRepo = new EmployerRepository($employer);
        
        $employerRepo->updateEmployer([
            'status' => 1
        ]);

        return redirect()->back()->with('message_success', 'アカウント削除申請を取り消しました');
    }
}
