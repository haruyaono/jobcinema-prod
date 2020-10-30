<?php

namespace App\Job\Users\Requests;

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
                'data.apply.year' => 'required|integer|digits:4',
                'data.apply.month' => 'required|integer|digits:2',
                'data.apply.date' => 'required|integer|digits:2',
                'full_date' => 'date|after_or_equal:' . today()->format('Y-m-d'),
            ];
        } elseif ($this->flag == 'SaveTmpAdoptStatus') {
            $data = [
                'data.apply.s_nofirst_attendance' => 'required|string|max:1000',
            ];
        }
        return $data;
    }

    public function messages()
    {
        return [
            'full_date.after_or_equal' => ':attribute は現在より後の日付を入力してください。',
        ];
    }

    protected function validationData()
    {
        $data = parent::validationData();
        $this->flag = $data['data']['Apply']['pushed'];

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
