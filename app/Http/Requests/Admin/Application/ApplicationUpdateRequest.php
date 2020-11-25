<?php

namespace App\Http\Requests\Admin\Application;

use App\Models\Apply;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationUpdateRequest extends FormRequest
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
            'data.Application.s_recruit_status' => 'required|not_in:null',
            'data.Application.e_recruit_status' => 'required|not_in:null',
            'data.Application.s_first_attendance' => 'nullable|date|after_or_equal:' . $this->model->created_at->format('Y-m-d'),
            'data.Application.e_first_attendance' => 'nullable|date|after_or_equal:' . $this->model->created_at->format('Y-m-d'),
            'data.Application.s_nofirst_attendance' => 'nullable|string|max:1000',
            'data.Application.e_nofirst_attendance' => 'nullable|string|max:1000',
            'data.Application.congrats_status' => 'required|not_in:null',
            'data.Application.congrats_amount' => 'required|integer',
            'data.Application.recruitment_status' => 'required|not_in:null',
            'data.Application.recruitment_fee' => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'data.Application.s_recruit_status' => '採用ステータス（応募者）',
            'data.Application.s_recruit_status' => '採用ステータス（企業）',
            'data.Application.s_first_attendance' => '初出社日（応募者）',
            'data.Application.e_first_attendance' => '初出社日（企業）',
            'data.Application.s_nofirst_attendance' => '初出社日が未定の理由（応募者）',
            'data.Application.e_nofirst_attendance' => '初出社日が未定の理由（企業）',
            'data.Application.congrats_status' => 'お祝い金フラグ',
            'data.Application.congrats_amount' => 'お祝い金の金額',
            'data.Application.recruitment_status' => '成果報酬フラグ',
            'data.Application.recruitment_fee' => '成果報酬の金額',
        ];
    }

    public function messages()
    {
        return [
            'data.Application.s_first_attendance.after_or_equal' => ':attribute は応募日以降の日付を入力してください。',
            'data.Application.e_first_attendance.after_or_equal' => ':attribute は応募日以降の日付を入力してください。',
        ];
    }

    public function validationData()
    {
        $data = parent::validationData();
        $this->model = Apply::find($data['data']['Application']['id']);

        return $data;
    }
}
