<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubImageUploadRequest extends FormRequest
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
            'job_sub_img' => 'image|max:20000|mimes:jpeg,gif,png',
        ];
    }
    public function messages()
    {
        return [
            "image" => "画像にしてください。",
            "max" => [
                'file' => '20MB以下のファイルを選択してください。'
            ],
            'mimes'  => '登録できる画像はJPEG/GIF/PNG形式のみです。',
        ];
    }
}
