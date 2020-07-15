<?php

namespace App\Job\Categories\Repositories\Interfaces;

// use App\Shop\Categories\Category;
use App\Job\JobItems\JobItem;
use App\Job\Categories\StatusCategory;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function listCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection;

    public function listCategoriesByslug(string $parentSlug, string $childSlug = '') : Collection;

    public function updateCategory(array $data): bool;

    public function findCategoryById(int $id);

    public function associateJobItem(JobItem $jobitem);
}