<?php


namespace App\Http\Requests\Admin\Notice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoticeRequest extends FormRequest
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
            'data.Notice.subject' => 'required|string',
            'data.Notice.content' => 'required|string',
            'data.Notice.target' => 'required|in:全体,企業,応募者',
            'data.Notice.is_delivered' => 'required|bool',
        ];
    }

    public function attributes()
    {
        return [
            'data.Notice.subject' => '件名',
            'data.Notice.content' => '本文',
            'data.Notice.target' => '対象',
            'data.Notice.is_delivered' => '配信',
        ];
    }
}