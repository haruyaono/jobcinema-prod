<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieUploadRequest extends FormRequest
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
            'data.File.movie' => 'max:80000|mimes:mp4,qt,x-ms-wmv,mpeg,x-msvideo',
        ];
    }
    public function messages()
    {
        return [
            // "required" => "登録したい動画が選ばれていません。",
            "max" => [
                'file' => '80MB以下のファイルを選択してください。'
            ],
            'mimes'  => '登録できる動画はMP4/MOV/WMV/MPEG/MPG/AVI形式のみです。',
        ];
    }
}
