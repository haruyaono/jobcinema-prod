<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Models\CongratsMoney;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Setting\Reward\StoreRewardRequest;
use App\Http\Requests\Admin\Setting\Reward\UpdateRewardRequest;
use Illuminate\Support\Arr;
use App\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;

class RewardController extends Controller
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
            return $value->congratsMoney == null;
        });

        return view('admin.setting.reward.index', [
            'rewards' => CongratsMoney::orderBy('amount', 'asc')->get(),
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
        return view('admin.setting.reward.create', [
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
    public function store(StoreRewardRequest $request)
    {
        CongratsMoney::create($request->input('data.Reward'));
        return redirect()->route('reward.index')->with('status', '作成しました！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return view('admin.setting.reward.show', [
            'reward' =>  CongratsMoney::find($id)
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
        return view('admin.setting.reward.edit', [
            'reward' => CongratsMoney::find($id),
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
    public function update(UpdateRewardRequest $request, int $id)
    {
        $reward = CongratsMoney::find($id);
        $reward->update(Arr::except($request->input('data.Reward'), ['id']));

        return redirect()->route('reward.index')->with('status', '保存しました！');
    }

    /**
     * Delete the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $reward = CongratsMoney::find($id);
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
