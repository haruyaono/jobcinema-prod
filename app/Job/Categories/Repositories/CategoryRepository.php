<?php

namespace App\Job\Categories\Repositories;

use App\Job\Categories\StatusCategory;
use App\Job\Categories\TypeCategory;
use App\Job\Categories\HourlySalaryCategory;
use App\Job\Categories\AreaCategory;
use App\Job\Categories\DateCategory;
// use App\Job\Categories\Exceptions\CategoryInvalidArgumentException;
// use App\Job\Categories\Exceptions\CategoryNotFoundException;
use App\Job\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Job\JobItems\JobItem;
// use App\Job\JobItems\Transformations\JobItemTransformable;
// use App\Job\Tools\UploadableTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{

    /**
     * CategoryRepository constructor.
     * @param StatusCategory $statusCategory
     */

     public function __construct(
         StatusCategory $statusCategory,
         TypeCategory $typeCategory, 
         HourlySalaryCategory $hourlySalaryCategory, 
         AreaCategory $areaCategory, 
         DateCategory $dateCategory)
     {  
        $this->model = [$statusCategory,$typeCategory,$hourlySalaryCategory,$areaCategory,$dateCategory];
     }

      /**
     * @param int $flag_category
     * @return Category
     */
    public function determineCategory(int $flag_category)
    {
        switch ($flag_category) {
            case 0:
                return $this->model[0];
                break;
            case 1:
                return $this->model[1];
                break;
            case 2:
                return $this->model[2];
                break;
            case 3:
                return $this->model[3];
                break;
            case 4:
                return $this->model[4];
                break;
        }
    }

    /**
      * all categories
      */
      public function allCategories()
      {
          return $this->model;;
      }


    /**
      * List all categories
      *
      * @param string $order 
      * @param string $sort
      * @param array $except
      * @return \Illuminate\Support\Collection
      */
      public function listCategories(int $flag_category, string $order = 'id', string $sort = 'desc', $except = []) : Collection
      {
          return $this->determineCategory($flag_category)->orderBy($order, $sort)->get()->except($except);
      }

    /**
     * @param int $id
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function findCategoryById(int $id, int $flag_category)
    {
        // try {
            return $this->determineCategory($flag_category)->findOrFail($id);
        // } catch (ModelNotFoundException $e) {
        //     throw new CategoryNotFoundException($e->getMessage());
        // }
    }

}
