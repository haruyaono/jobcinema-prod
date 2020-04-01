<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpPreRegisterRequest extends FormRequest
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
            'email' => 'required|email|string|max:191|unique:employers|unique:users',
            'password' => 'required|min:6|string|max:191|confirmed',
            'e_last_name' => 'required|string|max:191',
            'e_first_name' => 'required|string|max:191',
            'e_phone1' => 'required|numeric|digits_between:2,5',
            'e_phone2' => 'required|numeric|digits_between:1,4',
            'e_phone3' => 'required|numeric|digits_between:3,4',
            'cname' => 'required|string|max:191',
        ];
    }
    
}