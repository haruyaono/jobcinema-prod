<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Enterprise\UpdateEnterpriseRequest;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;

class EnterpriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = Company::query();
        foreach ($request->only(['enterprise', 'employer']) as $key => $value) {
            foreach ($value as $k => $v) {
                if ($v == null || $k == 'created_at' || $k == 'updated_at') continue;

                if ($key == 'enterprise') {
                    if ($k == 'id') {
                        $ids = explode(',', $v);
                        $model->whereIn($k, $ids);
                        continue;
                    }
                    $model->where($k, $v);
                } else {
                    $model->whereHas('employer', function ($query) use ($k, $v) {
                        if ($k == 'id') {
                            $ids = explode(',', $v);
                            $query->whereIn($k, $ids);
                        } else {
                            $query->where($k, $v);
                        }
                    });
                }
            }
        }

        $this->getCalendarQuery($model, $request->input('enterprise.created_at.start'), $request->input('enterprise.created_at.end'), 'created_at');
        $this->getCalendarQuery($model, $request->input('enterprise.updated_at.start'), $request->input('enterprise.updated_at.end'), 'updated_at');

        $enterprises = $model->get();
        $param = $request->all();

        return view('admin.enterprise.index', compact('enterprises', 'param'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $enterprise = Company::find($id);

        return view('admin.enterprise.show', compact('enterprise'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $enterprise = Company::find($id);

        return view('admin.enterprise.edit', [
            'enterprise' => $enterprise,
            'industries' => config('const.INDUSTORIES'),
            'employeeNumbers' => config('const.EMPLOYEE_NUMBERS'),
            'postcode' => $enterprise->list_postcode,
            'foundation' => $enterprise->list_foundation
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEnterpriseRequest $request, $id)
    {
        $enterprise = Company::find($id);
        $data = $request->input('data.Enterprise');

        $data['postcode'] =  isset($data['postcode01']) && isset($data['postcode02']) ? $data['postcode01'] . "-" .  $data['postcode02'] : null;
        $data['foundation'] =  isset($data['f_year']) && isset($data['f_month']) ? $data['f_year'] . " 年 " . $data['f_month'] . " 月" : null;

        $enterprise->update(Arr::except($data, ['postcode01', 'postcode02', 'f_year', 'f_month']));

        return redirect()->back()->with('status', '保存しました！');
    }
}
