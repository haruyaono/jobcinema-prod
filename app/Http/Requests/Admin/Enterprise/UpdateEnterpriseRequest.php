<?php

namespace App\Http\Requests\Admin\Enterprise;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnterpriseRequest extends FormRequest
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
            'data.Enterprise.cname' => 'nullable|string|max:191',
            'data.Enterprise.cname_katakana' => 'nullable|string|max:191|katakana',
            'data.Enterprise.postcode01' => 'nullable|numeric|digits:3|required_with:data.Enterprise.postcode02',
            'data.Enterprise.postcode02' => 'nullable|numeric|digits:4|required_with:data.Enterprise.postcode01',
            'data.Enterprise.prefecture' => 'nullable|string|max:191',
            'data.Enterprise.address' => 'nullable|string|max:191',
            'data.Enterprise.ceo' => 'nullable|max:191',
            'data.Enterprise.f_year' => 'nullable|numeric|digits:4|required_with:data.Enterprise.f_month',
            'data.Enterprise.f_month' => 'required_with:data.Enterprise.f_month',
            'data.Enterprise.capital' => 'nullable|max:191',
            'data.Enterprise.description' => 'nullable|string|max:400',
            'data.Enterprise.website' => 'nullable|max:191',
            'data.Enterprise.phone1' => 'nullable|numeric|digits_between:2,5|required_with:data.Enterprise.phone2,data.Enterprise.phone3',
            'data.Enterprise.phone2' => 'nullable|numeric|digits_between:1,4|required_with:data.Enterprise.phone1,data.Enterprise.phone3',
            'data.Enterprise.phone3' => 'nullable|numeric|digits_between:3,4|required_with:data.Enterprise.phone1,data.Enterprise.phone2',
            'data.Enterprise.transfer_person_name' => 'required|string|max:191|katakana',
        ];
    }

    public function attributes()
    {
        return [
            'data.Enterprise.cname' => '企業名（店舗）',
            'data.Enterprise.cname_katakana' => '企業名（カナ）',
            'data.Enterprise.postcode01' => '郵便番号1',
            'data.Enterprise.postcode02' => '郵便番号2',
            'data.Enterprise.prefecture' => '都道府県',
            'data.Enterprise.address' => '住所',
            'data.Enterprise.ceo' => '代表者様',
            'data.Enterprise.f_year' => '設立 年',
            'data.Enterprise.f_month' => '設立 月',
            'data.Enterprise.capital' => '資本金',
            'data.Enterprise.industry' => '業種',
            'data.Enterprise.description' => '事業内容',
            'data.Enterprise.employee_number' => '従業員数',
            'data.Enterprise.website' => 'ホームページ',
            'data.Enterprise.phone1' => '求職者が連絡する電話番号1',
            'data.Enterprise.phone2' => '求職者が連絡する電話番号2',
            'data.Enterprise.phone3' => '求職者が連絡する電話番号3',
            'data.Enterprise.transfer_person_name' => '振込人名義（カタカナ）',
        ];
    }
    public function withValidator($validator)
    {
        $validator->sometimes('data.Enterprise.f_month', 'required', function ($input) {
            return isset($input->data['Enterprise']['f_year']);
        });
    }
}
