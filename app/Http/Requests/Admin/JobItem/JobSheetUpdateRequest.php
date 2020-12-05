<?php

namespace App\Http\Requests\Admin\JobItem;

use App\Http\Requests\Media\ImageUploadRequest;
use App\Http\Requests\Media\MovieUploadRequest;
use Illuminate\Foundation\Http\FormRequest;

class JobSheetUpdateRequest extends FormRequest
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
        $formRequests = [
            ImageUploadRequest::class,
            MovieUploadRequest::class
        ];

        $rules = [
            'data.JobSheet.categories.status.id' => 'required',
            'data.JobSheet.categories.type.id' => 'required',
            'data.JobSheet.categories.area.id' => 'required',
            'data.JobSheet.categories.salary' => 'required',
            'data.JobSheet.categories.salary.0.parent_id' => 'required_without_all:data.JobSheet.categories.salary.1.id,data.JobSheet.categories.salary.2.id',
            'data.JobSheet.categories.salary.1.parent_id' => 'required_without_all:data.JobSheet.categories.salary.0.id,data.JobSheet.categories.salary.2.id',
            'data.JobSheet.categories.salary.2.parent_id' => 'required_without_all:data.JobSheet.categories.salary.0.id,data.JobSheet.categories.salary.1.id',
            'data.JobSheet.categories.salary.0.parent_slug' => 'required',
            'data.JobSheet.categories.salary.1.parent_slug' => 'required',
            'data.JobSheet.categories.salary.2.parent_slug' => 'required',
            'data.JobSheet.categories.date.id' => 'required',
            'data.JobSheet.categories.status.ancestor_slug' => 'required',
            'data.JobSheet.categories.status.ancestor_id' => 'required',
            'data.JobSheet.categories.type.ancestor_slug' => 'required',
            'data.JobSheet.categories.type.ancestor_id' => 'required',
            'data.JobSheet.categories.area.ancestor_slug' => 'required',
            'data.JobSheet.categories.area.ancestor_id' => 'required',
            'data.JobSheet.categories.salary_ancestor.slug' => 'required',
            'data.JobSheet.categories.salary_ancestor.id' => 'required',
            'data.JobSheet.categories.date.ancestor_slug' => 'required',
            'data.JobSheet.categories.date.ancestor_id' => 'required',
            'data.JobSheet.pub_start_flag' => 'required',
            'data.JobSheet.pub_end_flag' => 'required',
            'data.JobSheet.pub_start_date' => 'date|after_or_equal:' . today()->format('Y-m-d'),
            'data.JobSheet.pub_end_date' => 'date|after:data.JobSheet.pub_start_date',
            'data.JobSheet.job_title' => 'max:30',
            'data.JobSheet.job_intro' => 'max:250',
            'data.JobSheet.job_office' => 'max:191',
            'data.JobSheet.job_office_address' => 'max:191',
            'data.JobSheet.job_type' => 'max:191',
            'data.JobSheet.job_desc' => 'max:700',
            'data.JobSheet.job_salary' => 'max:191',
            'data.JobSheet.salary_increase' => 'max:191',
            'data.JobSheet.job_target' => 'max:400',
            'data.JobSheet.job_time' => 'max:400',
            'data.JobSheet.job_treatment' => 'max:400',
            'data.JobSheet.remarks' => 'max:1300',
            'data.JobSheet.job_q1' => 'max:191',
            'data.JobSheet.job_q2' => 'max:191',
            'data.JobSheet.job_q3' => 'max:191',
        ];

        foreach ($formRequests as $source) {
            $rules = array_merge(
                $rules,
                (new $source($this->data))->rules()
            );
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'data.JobSheet.categories.salary.0.parent_id.required_without_all' => '最低給与の種類は必須項目です',
            'data.JobSheet.categories.salary.1.parent_id.required_without_all' => '最低給与の種類は必須項目です',
            'data.JobSheet.categories.salary.2.parent_id.required_without_all' => '最低給与の種類は必須項目です',
            'data.JobSheet.categories.salary.0.parent_slug.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.salary.1.parent_slug.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.salary.2.parent_slug.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.status.ancestor_slug.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.status.ancestor_id.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.type.ancestor_slug.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.type.ancestor_id.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.area.ancestor_slug.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.area.ancestor_id.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.salary_ancestor.slug.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.salary_ancestor.id.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.date.ancestor_slug.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.date.ancestor_id.required' => '無効な値または未入力項目があります',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('data.JobSheet.pub_start_date', 'required', function ($input) {
            return $input->data['JobSheet']['pub_start_flag'] == 1;
        });

        $validator->sometimes('data.JobSheet.pub_end_date', 'required', function ($input) {
            return $input->data['JobSheet']['pub_end_flag'] == 1;
        });

        $validator->sometimes('data.JobSheet.pub_end_date', 'required|after:' . today()->format('Y-m-d'), function ($input) {
            return $input->data['JobSheet']['pub_end_flag'] == 1 && $input->data['JobSheet']['pub_start_flag'] == 0;
        });
    }
}
