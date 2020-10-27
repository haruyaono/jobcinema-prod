<?php

namespace App\Job\Categories\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function listCategories(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection;

    public function listCategoriesByslug(string $parentSlug, string $childSlug = ''): array;

    public function updateCategory(array $data): bool;

    public function findCategoryById(int $id);

    public function findCategoryBySlig(string $slug);
}
