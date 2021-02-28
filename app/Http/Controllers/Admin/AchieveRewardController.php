<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AchieveReward\UpdateAchieveRewardRequest;
use App\Models\AchieveRewardBilling;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AchieveRewardController extends Controller
{
    public function index(Request $request)
    {
        $achieve_rewards = AchieveRewardBilling::all();
        return view('admin.achieve_reward.index', compact('achieve_rewards'));
    }

    public function show($id)
    {
        $achieve_reward = AchieveRewardBilling::find($id);

        return view('admin.achieve_reward.show', compact('achieve_reward'));
    }

    public function edit($id)
    {
        $achieve_reward = AchieveRewardBilling::find($id);

        return view('admin.achieve_reward.edit', compact('achieve_reward'));
    }

    public function update(UpdateAchieveRewardRequest $request, $id)
    {
        $achieve_reward = AchieveRewardBilling::find($id);
        $data = $request->input('data.AchieveReward');

        $achieve_reward->update(Arr::except($data, ['id']));

        return redirect()->back()->with('status', '保存しました！');
    }
}
