<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

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
            'data.apply.last_name' => 'required|string|max:191|kana',
            'data.apply.first_name' => 'required|string|max:191|kana',
            'data.apply.phone1' => 'required|numeric|digits_between:2,5',
            'data.apply.phone2' => 'required|numeric|digits_between:1,4',
            'data.apply.phone3' => 'required|numeric|digits_between:3,4',
            'data.apply.gender' => 'required',
            'data.apply.age' => 'required|numeric|between:15,99',
            'data.apply.postcode01' => 'required|numeric|digits:3',
            'data.apply.postcode02' => 'required|numeric|digits:4',
            'data.apply.prefecture' => 'required|string|max:191',
            'data.apply.city' => 'required|string|max:191',
            'data.apply.occupation' => 'required|not_in: 0',
            'data.apply.final_education' => 'required|not_in: 0',
            'data.apply.work_start_date' => 'required',
            'data.apply.job_msg' => 'max:1000',
            'data.apply.job_q1' => 'max:1000',
            'data.apply.job_q2' => 'max:1000',
            'data.apply.job_q3' => 'max:1000',
        ];
    }

    public function messages()
    {
        return [
            'occupation.not_in' => '職業が選択されていません。',
            'final_education.not_in' => '最終学歴が選択されていません。'
        ];
    }
}
