<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job\JobItems\JobItem;
use App\Job\Categories\Category; 
use App\Job\Categories\Repositories\Interfaces\CategoryRepositoryInterface;


class CategoryController extends Controller
{
      /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;
    
     /**
     * CategoryController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
      CategoryRepositoryInterface $categoryRepository
    ) {

      $this->categoryRepo = $categoryRepository;
    }


    public function getAllCat($url) {
        $categories = $this->categoryRepo->listCategories();

        return view('jobs.job_cats', compact('categories', 'url'));
    }

    public function getTypeCat($id) {
        $jobs = JobItem::ActiveJobitem()->where('type_cat_id', $id)->paginate(20);
        $typeCatArchive = TypeCategory::find($id);

        return view('jobs.type_cat', compact('jobs', 'typeCatArchive'));
    }

    public function getAreaCat($id) {
        $jobs = JobItem::ActiveJobitem()->where('area_cat_id', $id)->paginate(20);
        $areaCatArchive = AreaCategory::find($id);

        return view('jobs.area_cat', compact('jobs', 'areaCatArchive'));
    }
    public function getHourlySalaryCat($id) {
        $jobs = JobItem::ActiveJobitem()->where('hourly_salary_cat_id', $id)->paginate(20);
        $hourlySalaryCatArchive = HourlySalaryCategory::find($id);

        return view('jobs.hourly_salary', compact('jobs', 'hourlySalaryCatArchive'));
    }
}
