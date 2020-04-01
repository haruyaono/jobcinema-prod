<?php

namespace App\Http\Requests;

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
            'job_title' => 'max:30',
            'job_intro' => 'max:250',
            'job_office' => 'max:191',
            'job_office_address' => 'max:191',
            'job_type' => 'max:191',
            'job_desc' => 'max:700',
            'job_hourly_salary' => 'max:191',
            'salary_increase' => 'max:191',
            'job_target' => 'max:400',
            'job_time' => 'max:400',
            'job_treatment' => 'max:400',
            'remarks' => 'max:1300',
        ];
    }
}
