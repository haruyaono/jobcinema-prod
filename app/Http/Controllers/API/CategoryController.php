<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Job\Categories\Category;
use App\Job\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     *  @var CategoryRepositoryInterface
     */
    private $categoryRepo;
    private $category;

    /**
     * CategoryController constructor.
     * @param Category $category
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        Category $category,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->category = $category;
        $this->categoryRepo = $categoryRepository;
    }

    public function getAllCategory()
    {

        return response()->json(['categoryList' => $this->categoryRepo->listCategories('id', 'asc')]);
    }

    public function getCategoryNameList(Request $request)
    {
        $content = $request->json()->all();
        return response()->json(['nameList' => $this->category->getNameList($content['idList'])]);
    }
}
