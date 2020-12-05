<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Setting\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Setting\Category\UpdateCategoryRequest;
use Illuminate\Support\Arr;
use App\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
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
        return view('admin.setting.category.index', [
            'categories' => $this->categoryRepository->getCategories()
        ]);
    }

    /**
     * Create the form for storing the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.category.create', [
            'categories' => $this->categoryRepository->getCategories()
        ]);
    }

    /**
     * Store the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {

        $data = $request->input('data.Category');
        $parent = Category::find($data['parent_id']);

        if ($parent->slug == 'salary' && isset($data['sub_parent_id'])) {
            $parent = Category::find($data['sub_parent_id']);
        }

        if ($parent->slug == null) return redirect()->back();

        $parent->children()->create(Arr::except($data, ['parent_id', 'sub_parent_id']));

        return redirect()->route('category.index')->with('status', '作成しました！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return view('admin.setting.category.show', [
            'category' =>  Category::withDepth()->find($id)
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
        return view('admin.setting.category.edit', [
            'category' => Category::find($id),
            'categories' => $this->categoryRepository->getCategories()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $category = Category::find($id);
        $category->update($request->input('data.Category'));

        return redirect()->route('category.index')->with('status', '保存しました！');
    }

    /**
     * Delete the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $category = Category::find($id);
        $status = 0;

        // カテゴリが既に求人票と紐付いている場合はエラー返す
        if ($category->jobitems->isEmpty()) {
            $category->delete();
            $message = '削除しました！';
            $status = 1;
        } else {
            $message = '求人票と紐付いているため削除出来ません！ee';
        }

        return response()->json([
            'message' => $message,
            'status' => $status,
        ]);
    }
}
