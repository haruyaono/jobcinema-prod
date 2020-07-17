<?php

namespace App\Job\Applies\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplyRequest extends FormRequest
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
            'last_name' => 'required|string|max:191|kana',
            'first_name' => 'required|string|max:191|kana',
            'phone1' => 'required|numeric|digits_between:2,5',
            'phone2' => 'required|numeric|digits_between:1,4',
            'phone3' => 'required|numeric|digits_between:3,4',
            'gender' => 'required',
            'age' => 'required|numeric|between:15,99',
            'zip31' => 'required|numeric|digits:3',
            'zip32' => 'required|numeric|digits:4',
            'pref31' => 'required|string|max:191',
            'addr31' => 'required|string|max:191',
            'occupation' => 'required|not_in: 0',
            'final_education' => 'required|not_in: 0',
            'work_start_date' => 'required',
            'job_msg' => 'max:1000',
            'job_q1' => 'max:1000',
            'job_q2' => 'max:1000',
            'job_q3' => 'max:1000',
        ];
    }

    public function messages() {
        return [
            'occupation.not_in' => '職業が選択されていません。',
            'final_education.not_in' => '最終学歴が選択されていません。'
        ];
    }
}