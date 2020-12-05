<?php

namespace App\Http\Controllers\Front;

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

    public function index($url)
    {
        if ($url != 'type' || $url != 'area' || $url != 'salary') {
            abort(404);
        }

        $categories = $this->CategoryRepository->getCategories();

        return view('front.jobs.category', compact('categories', 'url'));
    }
}
