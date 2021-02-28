<?php


namespace App\Http\Requests\Admin\AchieveReward;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAchieveRewardRequest extends FormRequest
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
            'data.AchieveReward.is_payed' => 'required|bool',
            'data.AchieveReward.payed_at' => 'required|date',
        ];
    }

    public function attributes()
    {
        return [
            'data.AchieveReward.is_payed' => '支払い',
            'data.AchieveReward.payed_at' => '支払い日',
        ];
    }
}