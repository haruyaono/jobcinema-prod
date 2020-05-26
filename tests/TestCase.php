<?php

namespace Tests;

use App\Job\JobItems\JobItem;
use App\Models\Company;
use App\Job\Categories\StatusCategory;
use App\Job\Categories\TypeCategory;
use App\Job\Categories\AreaCategory;
use App\Job\Categories\HourlySalaryCategory;
use App\Job\Categories\DateCategory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    protected $faker;
    protected $jobitem;
    protected $statusCategory;
    protected $typeCategory;
    protected $areaCategory;
    protected $hourlysalaryCategory;
    protected $dateCategory;
    protected $baseQueryData;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->faker = Faker::create();
        $this->statusCategory = factory(StatusCategory::class)->create();
        $this->typeCategory = factory(TypeCategory::class)->create();
        $this->areaCategory = factory(AreaCategory::class)->create();
        $this->hourlysalaryCategory = factory(HourlySalaryCategory::class)->create();
        $this->dateCategory = factory(DateCategory::class)->create();

        $this->jobitem = factory(JobItem::class)->create([
            'status_cat_id' => $this->statusCategory,
            'type_cat_id' => $this->typeCategory,
            'area_cat_id' => $this->areaCategory,
            'hourly_salary_cat_id' => $this->hourlysalaryCategory,
            'date_cat_id' => $this->dateCategory
        ]);

        $this->baseQueryData = [
            'title' => '',
            'status_cat_id' => $this->statusCategory->id,
            'type_cat_id' => $this->typeCategory->id,
            'area_cat_id' => $this->areaCategory->id,
            'hourly_salary_cat_id' => $this->hourlysalaryCategory->id,
            'date_cat_id' => $this->dateCategory->id,
        ];
    }

    public function tearDown()
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }

 
   /**
     * Set the referer header to simulate a previous request.
     *
     * @param  string  $url
     * @return $this
     */
    public function from(string $url)
    {
        session()->setPreviousUrl(url($url));
        return $this;
    }
}
