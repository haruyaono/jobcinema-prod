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
            'cats_status.id' => 'required',
            'cats_type.id' => 'required',
            'cats_area.id' => 'required',
            'cats_salary_p.id' => 'required',
            'cats_salary.id' => 'required',
            'cats_date.id' => 'required',
           
            
        ];
    }
}
