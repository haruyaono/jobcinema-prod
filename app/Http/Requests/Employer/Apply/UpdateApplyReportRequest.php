<?php

namespace App\Http\Requests\Employer\Apply;

use App\Models\Apply;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApplyReportRequest extends FormRequest
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

    private $flag;
    private $model;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = [];

        if ($this->flag == 'SaveAdoptStatus') {
            $data = [
                'data.apply.year' => 'nullable|numeric|digits:4|required_with:data.apply.month,data.apply.date',
                'data.apply.month' => 'nullable|numeric|digits:2|required_with:data.apply.year,data.apply.date',
                'data.apply.date' => 'nullable|numeric|digits:2|required_with:data.apply.year,data.apply.month',
                'data.is_attendance' => 'nullable|required_with:data.apply.e_nofirst_attendance|numeric|size:1',
                'data.apply.e_nofirst_attendance' => 'nullable|required_without_all:data.apply.year,data.apply.month,data.apply.date|required_with:data.is_attendance|string|max:1000',
                'full_date' => 'nullable|date|after_or_equal:' . $this->model->created_at->format('Y-m-d') . '|required_without_all:data.apply.e_nofirst_attendance,data.is_attendance',
                'data.is_sendable' => 'nullable|numeric|size:1',
            ];
        } elseif ($this->flag == 'SaveUnAdoptStatus') {
            $data = [
                'data.apply.mail' => 'required|max:400',
            ];
        } elseif ($this->flag == 'SaveDeclineStatus') {
            $data = [
                'data.decline.flag' => 'required|not_in:0',
                'data.decline.text' => 'nullable|required_if:data.decline.flag,その他|max:400',
            ];
        }
        return $data;
    }
    public function attributes()
    {
        return [
            'data.apply.e_nofirst_attendance' => '初出社日未定',
            'data.apply.mail' => 'メール本文',
            'data.decline.flag' => '理由区分',
            'data.decline.text' => 'その他の理由'
        ];
    }


    public function messages()
    {
        return [
            'full_date.after_or_equal' => ':attribute は応募日以降の日付を入力してください。',
        ];
    }

    public function validationData()
    {
        $data = parent::validationData();
        $this->flag = $data['data']['Apply']['pushed'];
        $this->model = Apply::find($data['data']['Apply']['id']);

        if ($this->flag != 'SaveAdoptStatus') {
            return $data;
        }

        $data['full_date'] = null;

        if ($data['data']['apply']['year'] && $data['data']['apply']['month'] && $data['data']['apply']['date']) {
            $data['full_date'] = $data['data']['apply']['year'] . '-' . $data['data']['apply']['month'] . '-' . $data['data']['apply']['date'];
        }

        return $data;
    }
}
