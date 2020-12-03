<?php

namespace App\Http\Requests\Admin\Setting\Reward;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRewardRequest extends FormRequest
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
            'data.Reward.amount' => 'required|numeric',
            'data.Reward.category_id' => 'required|not_in:null|unique:congrats_monies,category_id,' . $this->data['Reward']['id'] . '|exists:categories,id',
            'data.Reward.label' => 'nullable|string|max:191',
        ];
    }

    public function attributes()
    {
        return [
            'data.Reward.amount' => '金額',
            'data.Reward.category_id' => 'カテゴリ',
            'data.Reward.label' => 'ラベル',
        ];
    }
}
