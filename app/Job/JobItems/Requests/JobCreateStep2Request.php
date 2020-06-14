<?php

namespace App\Job\JobItems\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobCreateStep2Request extends FormRequest
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
            'pub_start' => 'required',
            'pub_end' => 'required',
            'job_title' => 'required|max:30',
            'job_intro' => 'required|max:250',
            'job_office' => 'required|max:191',
            'job_office_address' => 'required|max:191',
            'job_type' => 'required|max:191',
            'job_desc' => 'required|max:700',
            'job_hourly_salary' => 'required|max:191',
            'salary_increase' => 'max:191',
            'job_target' => 'required|max:400',
            'job_time' => 'required|max:400',
            'job_treatment' => 'required|max:400',
            'remarks' => 'max:1300',
            'job_q1' => 'max:191',
            'job_q2' => 'max:191',
            'job_q3' => 'max:191',
        ];
    }
}
