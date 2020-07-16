<?php

namespace App\Job\Categories\Repositories;

use App\Job\Categories\Category;
use App\Job\Categories\Exceptions\CategoryNotFoundException;
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

    /**
     * List all categories by parent slug
     *
    *  @param string $childSlug
     * @param string $parentSlug
    * @return Collection
    */
    public function listCategoriesByslug(string $parentSlug, string $childSlug = '') : Collection
    {
        $categories = $this->listCategories();
        if($childSlug !== '') {
            return $categories->where('slug', $parentSlug)->first()->children->where('slug', $childSlug)->first()->children->sortKeysDesc()->values();
        }
        return $categories->where('slug', $parentSlug)->first()->children->sortKeysDesc()->values();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function updateCategory(array $data): bool
    {
        return $this->update($data);
    }

    /**
     * Find the category by ID
     *
     * @param int $id
     * @return Category
     * @throws CategoryNotFoundException : Category
     */
    public function findCategoryById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e);
        }
    }

    /**
     * @param JobItem $jobitem
     * @param array $data
     */
    public function associateJobItem(JobItem $jobitem)
    {
        $this->model->jobitems()->attach($jobitem);
    }
}
