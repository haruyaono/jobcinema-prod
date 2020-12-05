<?php

namespace App\Http\Requests\Admin\Setting\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'data.Category.name' => 'required|string|max:191',
            'data.Category.sort' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'data.Category.name' => 'カテゴリ名',
            'data.Category.sort' => '並び順',
        ];
    }
}
