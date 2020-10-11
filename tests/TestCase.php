<?php

namespace Tests;

use App\Job\JobItems\JobItem;
use App\Job\Users\User;
use App\Job\Categories\Category;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    protected $faker;
    protected $jobitem;
    protected $category;
    protected $user;
    protected $baseQueryData;

    /**
     * Set up the test
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker::create();

        $this->category = factory(Category::class)->create();
        $this->jobitem = factory(JobItem::class)->create();
        $this->user = factory(User::class)->create();
    }

    public function tearDown(): void
    {
        $this->artisan('migrate:refresh');
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
