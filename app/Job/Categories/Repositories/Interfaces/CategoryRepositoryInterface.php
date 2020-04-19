<?php

namespace App\Job\Categories\Repositories\Interfaces;

// use App\Shop\Categories\Category;
use App\Job\JobItems\JobItem;
use App\Job\Categories\StatusCategory;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function allCategories();
    public function listCategories(int $flag_category, string $order = 'id', string $sort = 'desc', $except = []) : Collection;

    // public function createCategory(array $params) : StatusCategory;

    // public function updateCategory(array $params) : StatusCategory;

    public function findCategoryById(int $id, int $flag_category);

    // public function deleteCategory() : bool;

    // public function associateJobitem(JobItem $jobitem);

    // public function findJobitems() : Collection;

    // public function syncJobitems(array $params);

    // public function detachJobitems();

    // public function findCategoryBySlug(array $slug) : StatusCategory;

    // public function rootCategories(string $string, string $string1);
}