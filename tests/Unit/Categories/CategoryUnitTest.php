<?php

namespace Tests\Unit\Categories;

use App\Job\JobItems\JobItem;
use App\Job\Categories\Category;
use App\Job\Categories\Exceptions\CategoryNotFoundException;
use App\Job\Categories\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class CategoryUnitTest extends TestCase
{
    /** @test */
    public function it_errors_when_the_category_is_not_found()
    {
        $this->expectException(CategoryNotFoundException::class);

        $category = new CategoryRepository(new Category);
        $category->findCategoryById(999);
    }

    /** @test */
    public function it_can_list_all_the_categories()
    {
        $categoryRepo = new CategoryRepository(new Category);
        $categories = $categoryRepo->listCategories();

        $this->assertGreaterThan(0, $categories->count());
    }

    /** @test */
    public function it_can_list_all_the_categories_by_slug()
    {
        $slug = 'status';
        $parentCategory = factory(Category::class)->create([
            'slug' => $slug
        ]);

        $this->category->parent_id = $parentCategory->id;
        $this->category->save();

        $categoryRepo = new CategoryRepository(new Category);

        $categories = $categoryRepo->listCategoriesByslug($slug);

        $this->assertGreaterThan(0, $categories->count());
    }

    /** @test */
    public function it_can_update_the_category()
    {

        $category = factory(Category::class)->create();

        $data = [
            'name' => $this->faker->word,
        ];

        $categoryRepo = new CategoryRepository($category);
        $updated = $categoryRepo->updateCategory($data);

        $category = $categoryRepo->findCategoryById($category->id);

        $this->assertTrue($updated);
        $this->assertEquals($data['name'], $category->name);
    }
}
