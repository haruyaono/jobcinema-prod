<?php

namespace App\Job\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'last_name' => 'required | max:191 | kana',
            'first_name' => 'required | max:191 | kana' ,
            'phone1' => 'required|numeric|digits_between:2,5',
            'phone2' => 'required|numeric|digits_between:1,4',
            'phone3' => 'required|numeric|digits_between:3,4',
            'age' => 'nullable|numeric|between:15,99',
            'zip31' => 'nullable|numeric|digits:3',
            'zip32' => 'nullable|numeric|digits:4',
            'pref31' => 'nullable|string|max:191',
            'addr31' => 'nullable|string|max:191',
        ];
    }
}