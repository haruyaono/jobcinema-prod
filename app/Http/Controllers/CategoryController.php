<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobItem;
use App\Models\TypeCat; 
use App\Models\AreaCat; 
use App\Models\HourlySalaryCat; 

class CategoryController extends Controller
{
    public function getAllCat($url) {
        $typeCats = TypeCat::all();
        $areaCats = AreaCat::all();
        $hourlySalaryCats = HourlySalaryCat::all();

        return view('jobs.job_cats', compact('typeCats', 'areaCats', 'hourlySalaryCats', 'url'));
    }

    public function getTypeCat($id) {
        $jobs = JobItem::ActiveJobitem()->where('type_cat_id', $id)->paginate(20);
        $typeCatArchive = TypeCat::find($id);

        return view('jobs.type_cat', compact('jobs', 'typeCatArchive'));
    }

    public function getAreaCat($id) {
        $jobs = JobItem::ActiveJobitem()->where('area_cat_id', $id)->paginate(20);
        $areaCatArchive = AreaCat::find($id);

        return view('jobs.area_cat', compact('jobs', 'areaCatArchive'));
    }
    public function getHourlySalaryCat($id) {
        $jobs = JobItem::ActiveJobitem()->where('hourly_salary_cat_id', $id)->paginate(20);
        $hourlySalaryCatArchive = HourlySalaryCat::find($id);

        return view('jobs.hourly_salary', compact('jobs', 'hourlySalaryCatArchive'));
    }
}
