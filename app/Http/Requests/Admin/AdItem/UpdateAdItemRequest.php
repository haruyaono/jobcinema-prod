<?php


namespace App\Http\Requests\Admin\AdItem;


use Illuminate\Foundation\Http\FormRequest;

class UpdateAdItemRequest extends FormRequest
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
            'data.AdItem.image' => 'nullable|file',
            'data.AdItem.is_view' => 'required|bool',
            'data.AdItem.started_at' => 'required|date',
            'data.AdItem.ended_at' => 'required|date|after:data.AdItem.started_at',
        ];
    }

    public function attributes()
    {
        return [
            'data.AdItem.image' => '画像',
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