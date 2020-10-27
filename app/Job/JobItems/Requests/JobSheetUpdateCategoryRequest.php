<?php

namespace App\Job\JobItems\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobSheetUpdateCategoryRequest extends FormRequest
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
        if ($this->cat_flag == "salary") {
            return [
                'data.JobSheet.categories.salary' => 'required',
                'data.JobSheet.categories.salary.0.parent_id' => 'required_without_all:data.JobSheet.categories.salary.1.id,data.JobSheet.categories.salary.2.id',
                'data.JobSheet.categories.salary.1.parent_id' => 'required_without_all:data.JobSheet.categories.salary.0.id,data.JobSheet.categories.salary.2.id',
                'data.JobSheet.categories.salary.2.parent_id' => 'required_without_all:data.JobSheet.categories.salary.0.id,data.JobSheet.categories.salary.1.id',
                'data.JobSheet.categories.salary.0.parent_slug' => 'required',
                'data.JobSheet.categories.salary.1.parent_slug' => 'required',
                'data.JobSheet.categories.salary.2.parent_slug' => 'required',
                'data.JobSheet.categories.salary_ancestor.slug' => 'required',
                'data.JobSheet.categories.salary_ancestor.id' => 'required',
            ];
        } else {
            return [
                'data.JobSheet.categories.' . $this->cat_flag . '.id' => 'required',
                'data.JobSheet.categories.' . $this->cat_flag . '.ancestor_slug' => 'required',
                'data.JobSheet.categories.' . $this->cat_flag . '.ancestor_id' => 'required',

            ];
        }
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
            'data.JobSheet.categories.salary_ancestor.slug.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.salary_ancestor.id.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.' . $this->cat_flag . '.ancestor_slug.required' => '無効な値または未入力項目があります',
            'data.JobSheet.categories.' . $this->cat_flag . '.ancestor_id.required' => '無効な値または未入力項目があります',
        ];
    }
}
