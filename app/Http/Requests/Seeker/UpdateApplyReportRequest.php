<?php

namespace App\Http\Requests\Seeker;

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
                'data.apply.year' => 'required|numeric|digits:4',
                'data.apply.month' => 'required|numeric|digits:2',
                'data.apply.date' => 'required|numeric|digits:2',
                'full_date' => 'date|after_or_equal:' . $this->model->created_at->format('Y-m-d'),
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
