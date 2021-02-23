<?php

use App\Models\JobItemCategory;
use Illuminate\Database\Seeder;

class JobItemCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobItemCategory::create([
            'job_item_id' => 1,
            'category_id' => 5,
            'ancestor_id' => 1,
            'ancestor_slug' => 'status',
            'parent_id' => NULL,
            'parent_slug' => NULL
        ]);
        JobItemCategory::create([
            'job_item_id' => 1,
            'category_id' => 17,
            'ancestor_id' => 7,
            'ancestor_slug' => 'type',
            'parent_id' => NULL,
            'parent_slug' => NULL
        ]);
        JobItemCategory::create([
            'job_item_id' => 1,
            'category_id' => 40,
            'ancestor_id' => 25,
            'ancestor_slug' => 'area',
            'parent_id' => NULL,
            'parent_slug' => NULL
        ]);
        JobItemCategory::create([
            'job_item_id' => 1,
            'category_id' => 51,
            'ancestor_id' => 49,
            'ancestor_slug' => 'salary',
            'parent_id' => 50,
            'parent_slug' => 'salary_h'
        ]);
        JobItemCategory::create([
            'job_item_id' => 1,
            'category_id' => 65,
            'ancestor_id' => 49,
            'ancestor_slug' => 'salary',
            'parent_id' => 64,
            'parent_slug' => 'salary_d'
        ]);
        JobItemCategory::create([
            'job_item_id' => 1,
            'category_id' => 88,
            'ancestor_id' => 49,
            'ancestor_slug' => 'salary',
            'parent_id' => 74,
            'parent_slug' => 'salary_m'
        ]);
        JobItemCategory::create([
            'job_item_id' => 1,
            'category_id' => 94,
            'ancestor_id' => 89,
            'ancestor_slug' => 'date',
            'parent_id' => NULL,
            'parent_slug' => NULL
        ]);
    }
}
