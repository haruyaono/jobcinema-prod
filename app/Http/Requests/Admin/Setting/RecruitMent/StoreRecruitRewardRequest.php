<?php

namespace App\Http\Requests\Admin\Setting\RecruitMent;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecruitRewardRequest extends FormRequest
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
            'data.RecruitReward.amount' => 'required|numeric',
            'data.RecruitReward.category_id' => 'required|not_in:null|unique:achievement_rewards,category_id|exists:categories,id',
            'data.RecruitReward.label' => 'nullable|string|max:191',
        ];
    }

    public function attributes()
    {
        return [
            'data.RecruitReward.amount' => '金額',
            'data.RecruitReward.category_id' => 'カテゴリ',
            'data.RecruitReward.label' => 'ラベル',
        ];
    }
}
