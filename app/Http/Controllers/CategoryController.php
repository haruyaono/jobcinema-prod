<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job\JobItems\JobItem;
use App\Job\Categories\TypeCategory; 
use App\Job\Categories\AreaCategory; 
use App\Job\Categories\HourlySalaryCategory; 

class CategoryController extends Controller
{
    public function getAllCat($url) {
        $typeCats = TypeCategory::all();
        $areaCats = AreaCategory::all();
        $hourlySalaryCats = HourlySalaryCategory::all();

        return view('jobs.job_cats', compact('typeCats', 'areaCats', 'hourlySalaryCats', 'url'));
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
