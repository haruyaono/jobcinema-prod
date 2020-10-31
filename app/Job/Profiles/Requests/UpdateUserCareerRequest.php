<?php

namespace App\Job\Profiles\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserCareerRequest extends FormRequest
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
            'data.profile.occupation' => 'required|not_in: 0',
            'data.profile.final_education' => 'required|not_in: 0',
            'data.profile.work_start_date' => 'required',
        ];
    }
}
