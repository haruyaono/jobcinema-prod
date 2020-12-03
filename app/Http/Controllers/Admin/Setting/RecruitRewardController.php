<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Models\AchievementReward;
use App\Http\Requests\Admin\Setting\RecruitMent\StoreRecruitRewardRequest;
use App\Http\Requests\Admin\Setting\RecruitMent\UpdateRecruitRewardRequest;
use Illuminate\Support\Arr;
use App\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;
use DB;

class RecruitRewardController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = collect($this->categoryRepository->getCategoriesByslug('status'));
        $non_attach_categories = $categories->filter(function ($value) {
            return $value->achievementReward == null;
        });

        return view('admin.setting.recruit_reward.index', [
            'rewards' => AchievementReward::orderBy('amount', 'asc')->get(),
            'non_attach_categories' => $non_attach_categories
        ]);
    }

    /**
     * Create the form for storing the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.recruit_reward.create', [
            'categories' => $this->categoryRepository->getCategoriesByslug('status')
        ]);
    }

    /**
     * Store the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecruitRewardRequest $request)
    {
        AchievementReward::create($request->input('data.RecruitReward'));
        return redirect()->route('recruit_reward.index')->with('status', '作成しました！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return view('admin.setting.recruit_reward.show', [
            'reward' =>  AchievementReward::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('admin.setting.recruit_reward.edit', [
            'reward' => AchievementReward::find($id),
            'categories' => $this->categoryRepository->getCategoriesByslug('status')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecruitRewardRequest $request, int $id)
    {
        $reward = AchievementReward::find($id);
        $reward->update(Arr::except($request->input('data.RecruitReward'), ['id']));

        return redirect()->route('recruit_reward.index')->with('status', '保存しました！');
    }

    /**
     * Delete the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $reward = AchievementReward::find($id);
        $status = 0;

        // 紐ずくカテゴリが既に求人票と紐付いている場合はエラー返す
        if ($reward->category->jobitems->isEmpty()) {
            $reward->delete();
            $message = '削除しました！';
            $status = 1;
        } else {
            $message = '求人票と紐付いているため削除出来ません！';
        }

        return response()->json([
            'message' => $message,
            'status' => $status,
        ]);
    }
}
