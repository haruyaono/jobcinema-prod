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
                'data.JobSheet.categories.salary.parent_id' => 'required',
                'data.JobSheet.categories.salary.id' => 'required',
            ];
        } else {
            return [
                'data.JobSheet.categories.' . $this->cat_flag . '.id' => 'required',

            ];
        }
    }
}
