<?php

namespace App\Job\Companies\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        ];
    }
}