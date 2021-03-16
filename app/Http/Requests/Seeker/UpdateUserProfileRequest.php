<?php

namespace App\Http\Requests\Seeker;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
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
            'data.user.last_name' => 'required|max:191|kana',
            'data.user.first_name' => 'required|max:191|kana',
            'data.profile.phone1' => 'required|numeric|digits_between:2,5',
            'data.profile.phone2' => 'required|numeric|digits_between:1,4',
            'data.profile.phone3' => 'required|numeric|digits_between:3,4',
            'data.profile.age' => 'nullable|numeric|between:15,99',
            'data.profile.postcode01' => 'nullable|numeric|digits:3',
            'data.profile.postcode02' => 'nullable|numeric|digits:4',
            'data.profile.prefecture' => 'nullable|string|max:191',
            'data.profile.city' => 'nullable|string|max:191',
            'data.profile.bank_name' => 'nullable|string|max:191',
            'data.profile.branch_name' => 'nullable|string|max:191',
            'data.profile.account_type' => 'nullable|string|max:191',
            'data.profile.account_number' => 'nullable|string|max:191',
            'data.profile.account_name' => 'nullable|string|max:191',
        ];
    }
}
