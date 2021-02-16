<?php

namespace App\Http\Requests\Admin\AdItem;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdItemRequest extends FormRequest
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
            'data.AdItem.company_id' => 'required|integer',
            'data.AdItem.job_item_id' => 'required|integer',
            'data.AdItem.image' => 'required|file',
            'data.AdItem.description' => 'required|string',
            'data.AdItem.price' => 'required|integer',
            'data.AdItem.is_view' => 'required|bool',
            'data.AdItem.started_at' => 'required|date|after:yesterday',
            'data.AdItem.ended_at' => 'required|date|after:data.AdItem.started_at',
        ];
    }

    public function attributes()
    {
        return [
            'data.AdItem.company_id' => '掲載企業',
            'data.AdItem.job_item_id' => '掲載広告',
            'data.AdItem.image' => '画像',
            'data.AdItem.description' => '画像説明',
            'data.AdItem.price' => '料金',
            'data.AdItem.is_view' => '掲載',
            'data.AdItem.started_at' => '開始日時',
            'data.AdItem.ended_at' => '終了日時',
        ];
    }

    public function getFileContent()
    {
        return $this->file("data.AdItem.image");
    }
}
