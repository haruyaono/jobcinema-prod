<?php

namespace App\Http\Controllers\Employer;

use Illuminate\Http\Request;
use App\Http\Requests\Employer\UpdateCompanyRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Facades\LineNotify;

class CompanyController extends Controller
{
    public function index()
    {
        return view('companies.mypage');
    }

    public function edit()
    {
        $industries = config('const.INDUSTORIES');
        $employeeNumbers = config('const.EMPLOYEE_NUMBERS');

        $employer = auth('employer')->user();
        $company = $employer->company;

        $postcode = $company->list_postcode;
        $foundation = $company->list_foundation;

        return view('companies.edit', compact('employer', 'industries', 'employeeNumbers', 'postcode', 'foundation'));
    }

    public function update(UpdateCompanyRequest $request)
    {

        $employer = auth('employer')->user();
        $company = $employer->company;

        $data = $request->input('company_form.company');
        $data['postcode'] =  $data['postcode01'] . "-" .  $data['postcode02'];
        $data['foundation'] =  $data['f_year'] . " 年 " . $data['f_month'] . " 月";

        unset($data['postcode01'], $data['postcode02'], $data['f_year'], $data['f_month']);

        $company->update($data);

        return redirect()->back()->with('message_success', '企業データを更新しました');
    }

    //mypage password change
    public function getChangePasswordForm()
    {
        return view('employer.passwords.changepassword');
    }

    public function postChangePassword(Request $request)
    {
        $employer = auth('employer')->user();

        //現在のパスワードが正しいかを調べる
        if (!(Hash::check($request->get('current-password'), $employer->password))) {
            return redirect()->back()->with('change_password_error', '現在のパスワードが間違っています。');
        }

        //現在のパスワードと新しいパスワードが違っているかを調べる
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with('change_password_error', '新しいパスワードが現在のパスワードと同じです。違うパスワードを設定してください。');
        }

        //パスワードのバリデーション。新しいパスワードは6文字以上、new-password_confirmationフィールドの値と一致しているかどうか。
        $request->validate([
            'current-password' => 'required|string|min:8',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //パスワードを変更
        $data = [
            'password' => bcrypt($request->get('new-password'))
        ];
        $employer->update($data);

        return redirect()->back()->with('change_password_success', 'パスワードを変更しました。');
    }

    //mypage email change
    public function getChangeEmail()
    {
        return view('employer.passwords.change_email');
    }
    public function postChangeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string|max:191|unique:employers',
        ]);

        $employer = auth('employer')->user();

        $data = [
            'email' => $request->get('email')
        ];
        $employer->update($data);

        return redirect()->back()->with('change_email_success', 'メールアドレスを変更しました。');
    }
}
