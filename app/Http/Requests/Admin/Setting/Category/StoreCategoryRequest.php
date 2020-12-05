<?php

namespace App\Http\Requests\Admin\Setting\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'data.Category.parent_id' => 'required|not_in:null|exists:categories,id',
            'data.Category.sub_parent_id' => 'nullable|exists:categories,id',
            'data.Category.sort' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'data.Category.name' => 'カテゴリ名',
            'data.Category.parent_id' => '親カテゴリ',
            'data.Category.sub_parent_id' => 'サブ親カテゴリ',
            'data.Category.sort' => '並び順',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('data.Category.sub_parent_id', 'required|not_in:null', function ($input) {
            $parent = Category::find($input['data']['Category']['parent_id']);
            return $parent->slug == 'salary';
        });
    }
}
