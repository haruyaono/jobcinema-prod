<?php


namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'data.user.last_name' => 'nullable|string|max:191',
            'data.user.first_name' => 'nullable|string|max:191',
            'data.user.last_name_kana' => 'nullable|string|max:191|katakana',
            'data.user.first_name_kana' => 'nullable|string|max:191|katakana',
            'data.user.email' => 'nullable|string|max:191',
            'data.profile.postcode' => 'nullable|string|max:191',
            'data.profile.prefecture' => 'nullable|string|max:191',
            'data.profile.city' => 'nullable|string|max:191',
            'data.profile.address' => 'nullable|string|max:191',
            'data.profile.building' => 'nullable|string|max:191',
            'data.profile.gender' => 'nullable|string|max:16',
            'data.profile.age' => 'nullable|numeric',
            'data.profile.phone1' => 'nullable|numeric',
            'data.profile.phone2' => 'nullable|numeric',
            'data.profile.phone3' => 'nullable|numeric',
            'data.profile.bank_code' => 'nullable|numeric',
            'data.profile.bank_name' => 'nullable|string|max:191',
            'data.profile.branch_code' => 'nullable|numeric',
            'data.profile.branch_name' => 'nullable|string|max:191',
            'data.profile.account_name' => 'nullable|string|max:191|katakana',
            'data.profile.occupation' => 'nullable|string|max:191',
            'data.profile.final_education' => 'nullable|string|max:191',
        ];
    }

    public function attributes()
    {
        return [
            'data.user.last_name' => '氏名 姓',
            'data.user.first_name' => '氏名 名　',
            'data.user.last_name_kana' => '氏名 セイ',
            'data.user.first_name_kana' => '氏名 メイ',
            'data.user.email' => 'メールアドレス',
            'data.profile.postcode' => '郵便番号',
            'data.profile.prefecture' => '都道府県',
            'data.profile.city' => '市区町村',
            'data.profile.address' => '丁目番地',
            'data.profile.building' => '建物名',
            'data.profile.gender' => '性別',
            'data.profile.age' => '年齢',
            'data.profile.phone1' => '電話番号1',
            'data.profile.phone2' => '電話番号2',
            'data.profile.phone3' => '電話番号3',
            'data.profile.bank_code' => '銀行コード',
            'data.profile.bank_name' => '銀行名',
            'data.profile.branch_code' => '支店コード',
            'data.profile.branch_name' => '支店名',
            'data.profile.account_name' => '口座名',
            'data.profile.occupation' => '職業',
            'data.profile.final_education' => '最終学歴',
        ];
    }

}