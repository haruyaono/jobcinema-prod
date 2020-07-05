<?php

namespace App\Job\Categories\Repositories;

use App\Job\Categories\Category;
// use App\Job\Categories\Exceptions\CategoryNotFoundException;
use App\Job\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Job\JobItems\JobItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Jsdecena\Baserepo\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    /**
     * CategoryRepository constructor.
     * @param Category $category
     */

    public function __construct(
        Category $category
    ) {
        $this->model = $category;
     }

    /**
    * List all categories
    *
    * @param string $order 
    * @param string $sort
    * @param array $columns
    * @return \Illuminate\Support\Collection
    */
    public function listCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort)->toTree();
    }
}
