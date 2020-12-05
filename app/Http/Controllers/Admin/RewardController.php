<?php

namespace App\Http\Controllers\Admin;

use App\Models\RewardBilling;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Reward\RewardBillingUpdateRequest;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = RewardBilling::query();

        foreach ($request->only(['user_id', 'apply_id']) as $key => $value) {
            if ($value == null) continue;
            $ids = explode(',', $value);
            $model->whereIn($key, $ids);
        }

        $this->getCalendarQuery($model, $request->input('created_at.start'), $request->input('created_at.end'), 'created_at');
        $this->getCalendarQuery($model, $request->input('payment_date.start'), $request->input('payment_date.end'), 'payment_date');

        if ($request->filled('status')) {
            $model->where('status', $request->get('status'));
        }
        if ($request->filled('billing_amount')) {
            $model->where('billing_amount', 'like', $request->get('billing_amount') . '%');
        }

        $rewards = $model->get();
        $param = $request->all();

        return view('admin.reward.index', compact('rewards', 'param'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reward = RewardBilling::find($id);
        return view('admin.reward.show', compact('reward'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reward = RewardBilling::find($id);
        return view('admin.reward.edit', compact('reward'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RewardBillingUpdateRequest $request, $id)
    {
        $reward = RewardBilling::find($id);
        $param = $request->all();

        $reward->update(Arr::except($param['data']['Reward'], ['id']));

        return redirect()->back()->with('status', '保存しました！');
    }
}
