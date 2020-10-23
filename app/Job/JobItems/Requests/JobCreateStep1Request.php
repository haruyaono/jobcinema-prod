<?php

namespace App\Job\JobItems\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobCreateStep1Request extends FormRequest
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
            'data.JobSheet.categories.status.id' => 'required',
            'data.JobSheet.categories.type.id' => 'required',
            'data.JobSheet.categories.area.id' => 'required',
            'data.JobSheet.categories.salary.parent_id' => 'required',
            'data.JobSheet.categories.salary.id' => 'required',
            'data.JobSheet.categories.date.id' => 'required',
        ];
    }
}
