<?php

namespace App\Job\JobItems\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobCreateTmpSaveOrConfirmRequest extends FormRequest
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
        if ($this->data['JobSheet']['pushed'] === "SaveTmpJob") {
            return [
                'data.JobSheet.pub_start_flag' => 'required',
                'data.JobSheet.pub_end_flag' => 'required',
                'data.JobSheet.job_title' => 'nullable|max:30',
                'data.JobSheet.job_intro' => 'nullable|max:250',
                'data.JobSheet.job_office' => 'nullable|max:191',
                'data.JobSheet.job_office_address' => 'nullable|max:191',
                'data.JobSheet.job_type' => 'nullable|max:191',
                'data.JobSheet.job_desc' => 'nullable|max:700',
                'data.JobSheet.job_salary' => 'nullable|max:191',
                'data.JobSheet.salary_increase' => 'nullable|max:191',
                'data.JobSheet.job_target' => 'nullable|max:400',
                'data.JobSheet.job_time' => 'nullable|max:400',
                'data.JobSheet.job_treatment' => 'nullable|max:400',
                'data.JobSheet.remarks' => 'nullable|max:1300',
                'data.JobSheet.job_q1' => 'nullable|max:191',
                'data.JobSheet.job_q2' => 'nullable|max:191',
                'data.JobSheet.job_q3' => 'nullable|max:191',
            ];
        }

        if ($this->data['JobSheet']['pushed'] === "SaveJob") {
            return [
                'data.File.isExist1' => 'required|size:1',
                'data.JobSheet.pub_start_flag' => 'required',
                'data.JobSheet.pub_end_flag' => 'required',
                'data.JobSheet.job_title' => 'required|max:30',
                'data.JobSheet.job_intro' => 'required|max:250',
                'data.JobSheet.job_office' => 'required|max:191',
                'data.JobSheet.job_office_address' => 'required|max:191',
                'data.JobSheet.job_type' => 'required|max:191',
                'data.JobSheet.job_desc' => 'required|max:700',
                'data.JobSheet.job_salary' => 'required|max:191',
                'data.JobSheet.salary_increase' => 'max:191',
                'data.JobSheet.job_target' => 'required|max:400',
                'data.JobSheet.job_time' => 'required|max:400',
                'data.JobSheet.job_treatment' => 'required|max:400',
                'data.JobSheet.remarks' => 'max:1300',
                'data.JobSheet.job_q1' => 'max:191',
                'data.JobSheet.job_q2' => 'max:191',
                'data.JobSheet.job_q3' => 'max:191',
            ];
        }

        return [];
    }
    public function messages()
    {
        return [
            'data.File.isExist1.required' => 'メイン画像は必須項目です。',
            'data.File.isExist1.size'  => 'メイン画像は必須項目です。',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('data.JobSheet.pub_start_date', 'required|date', function ($input) {
            return $input->data['JobSheet']['pub_start_flag'] == 1;
        });

        $validator->sometimes('data.JobSheet.pub_end_date', 'required|date', function ($input) {
            return $input->data['JobSheet']['pub_end_flag'] == 1;
        });
    }
}
