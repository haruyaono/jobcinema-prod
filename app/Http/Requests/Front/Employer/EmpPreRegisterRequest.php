<?php

namespace App\Http\Requests\Front\Employer;

use Illuminate\Foundation\Http\FormRequest;

class EmpPreRegisterRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_form.email' => 'required|email|string|max:191|unique:employers,email',
            'company_form.password' => 'required|min:8|string|max:191|confirmed',
            'company_form.last_name' => 'required|string|max:191',
            'company_form.first_name' => 'required|string|max:191',
            'company_form.phone1' => 'required|numeric|digits_between:2,5',
            'company_form.phone2' => 'required|numeric|digits_between:1,4',
            'company_form.phone3' => 'required|numeric|digits_between:3,4',
            'company_form.cname' => 'required|string|max:191',
        ];
    }

    public function attributes()
    {
        return [
            'company_form.email' => 'メールアドレス',
            'company_form.password' => 'パスワード',
            'company_form.last_name' => 'ご担当者様の姓',
            'company_form.first_name' => 'ご担当者様の名',
            'company_form.phone1' => 'ご担当者様電話番号1',
            'company_form.phone2' => 'ご担当者様電話番号2',
            'company_form.phone3' => 'ご担当者様電話番号3',
            'company_form.cname' => '企業名（店舗）',
        ];
    }
}
