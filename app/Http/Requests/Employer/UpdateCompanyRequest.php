<?php

namespace App\Http\Requests\Employer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'company_form.company.cname' => 'required|string|max:191',
            'company_form.company.cname_katakana' => 'required|string|max:191|katakana',
            'company_form.company.postcode01' => 'required|numeric|digits:3',
            'company_form.company.postcode02' => 'required|numeric|digits:4',
            'company_form.company.prefecture' => 'required|string|max:191',
            'company_form.company.address' => 'required|string|max:191',
            'company_form.company.ceo' => 'max:191',
            'company_form.company.f_year' => 'required|numeric|digits:4',
            'company_form.company.f_month' => 'required',
            'company_form.company.capital' => 'max:191',
            'company_form.company.industry' => 'required',
            'company_form.company.description' => 'required|string|max:400',
            'company_form.company.employee_number' => 'required',
            'company_form.company.website' => 'max:191',
            'company_form.company.phone1' => 'required|numeric|digits_between:2,5',
            'company_form.company.phone2' => 'required|numeric|digits_between:1,4',
            'company_form.company.phone3' => 'required|numeric|digits_between:3,4',
        ];
    }

    public function attributes()
    {
        return [
            'company_form.company.cname' => '企業名（店舗）',
            'company_form.company.cname_katakana' => '企業名（カナ）',
            'company_form.company.postcode01' => '郵便番号1',
            'company_form.company.postcode02' => '郵便番号2',
            'company_form.company.prefecture' => '都道府県',
            'company_form.company.address' => '住所',
            'company_form.company.ceo' => '代表者様',
            'company_form.company.f_year' => '設立 年',
            'company_form.company.f_month' => '設立 月',
            'company_form.company.capital' => '資本金',
            'company_form.company.industry' => '業種',
            'company_form.company.description' => '事業内容',
            'company_form.company.employee_number' => '従業員数',
            'company_form.company.website' => 'ホームページ',
            'company_form.company.phone1' => '求職者が連絡する電話番号1',
            'company_form.company.phone2' => '求職者が連絡する電話番号2',
            'company_form.company.phone3' => '求職者が連絡する電話番号3',
        ];
    }
}
