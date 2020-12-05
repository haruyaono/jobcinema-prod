<?php

namespace App\Repositories;

use App\Models\Category;
use Kalnoy\Nestedset\Collection;

class CategoryRepository extends AbstractRepository
{
    public function getModelClass(): string
    {
        return Category::class;
    }

    public function getCategories(): Collection
    {
        return Category::withDepth()->where('slug', '!=', 'unregistered')->orWhereNull('slug')->get()->toTree();
    }

    public function getCategoriesByslug(string $parentSlug, string $childSlug = ''): array
    {
        $categories = $this->getCategories();
        if ($childSlug !== '') {
            return $categories->where('slug', $parentSlug)->first()->children->where('slug', $childSlug)->first()->children->orderBy('sort', 'asc')->get();
        }
        return $categories->where('slug', $parentSlug)->first()->children->sortBy('sort')->all();
    }
}
