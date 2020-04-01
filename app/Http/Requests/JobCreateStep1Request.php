<?php

namespace App\Http\Requests;

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
            'status_cat_id' => 'required',
            'type_cat_id' => 'required',
            'area_cat_id' => 'required',
            'hourly_salary_cat_id' => 'required',
            'date_cat_id' => 'required',
           
            
        ];
    }
}
