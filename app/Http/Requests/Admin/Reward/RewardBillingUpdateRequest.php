<?php

namespace App\Http\Requests\Admin\Reward;

use Illuminate\Foundation\Http\FormRequest;

class RewardBillingUpdateRequest extends FormRequest
{
    private $model;

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
            'data.Reward.status' => 'required|not_in:null',
            'data.Reward.billing_amount' => 'required|integer',
            'data.Reward.payment_date' => 'nullable|date',
        ];
    }

    public function attributes()
    {
        return [
            'data.Reward.status' => 'ステータス',
            'data.Reward.billing_amount' => '金額',
            'data.Reward.payment_date' => '支払日',
        ];
    }
}
