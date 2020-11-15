<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    private $CategoryRepository;

    public function __construct(
        CategoryRepository $categoryRepository
    ) {
        $this->CategoryRepository = $categoryRepository;
    }

    public function index()
    {

        return response()->json(['categories' => $this->CategoryRepository->getCategories()]);
    }

    public function getNameList(Request $request)
    {
        $content = $request->json()->all();
        return response()->json(['nameList' => Category::find($content['idList'])->pluck('name')]);
    }
}
