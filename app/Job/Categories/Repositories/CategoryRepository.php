<?php

namespace App\Job\Categories\Repositories;

use App\Job\Categories\Category;
use App\Job\Categories\Exceptions\CategoryNotFoundException;
use App\Job\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        parent::__construct($category);
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
    public function listCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection
    {
        return $this->model->where('slug', '!=', 'unregistered')->orWhereNull('slug')->orderBy($order, $sort)->get($columns)->toTree();
    }

    /**
     * List all categories by parent slug
     *
     *  @param string $childSlug
     * @param string $parentSlug
     * @return array
     */
    public function listCategoriesByslug(string $parentSlug, string $childSlug = ''): array
    {
        $categories = $this->listCategories();
        if ($childSlug !== '') {
            return $categories->where('slug', $parentSlug)->first()->children->where('slug', $childSlug)->first()->children->orderBy('sort', 'asc')->get();
        }
        return $categories->where('slug', $parentSlug)->first()->children->sortBy('_lft')->all();
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
     * Find the category by slug
     *
     * @param string $slug
     * @return Category
     * @throws CategoryNotFoundException : Category
     */
    public function findCategoryBySlig(string $slug)
    {
        try {
            return $this->model->where('slug', $slug)->first();
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e);
        }
    }
}
