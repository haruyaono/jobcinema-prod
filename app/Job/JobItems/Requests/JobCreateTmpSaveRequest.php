<?php

namespace App\Job\JobItems\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobCreateTmpSaveRequest extends FormRequest
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
            'job_title' => 'nullable|max:30',
            'job_intro' => 'nullable|max:250',
            'job_img' => 'nullable',
            'job_office' => 'nullable|max:191',
            'job_office_address' => 'nullable|max:191',
            'job_type' => 'nullable|max:191',
            'job_desc' => 'nullable|max:700',
            'job_hourly_salary' => 'nullable|max:191',
            'salary_increase' => 'nullable|max:191',
            'job_target' => 'nullable|max:400',
            'job_time' => 'nullable|max:400',
            'job_treatment' => 'nullable|max:400',
            'remarks' => 'nullable|max:1300',
            'job_q1' => 'nullable|max:191',
            'job_q2' => 'nullable|max:191',
            'job_q3' => 'nullable|max:191',
        ];
    }
}
