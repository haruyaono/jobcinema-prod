<?php

namespace Tests\Unit\JobItems;

use App\Job\Employers\Employer;
use App\Job\Applies\Apply;
use App\Job\Applies\Repositories\ApplyRepository;
use App\Job\JobItems\JobItem;
use App\Job\JobItems\Exceptions\JobItemNotFoundException;
use App\Job\JobItems\Exceptions\AppliedJobItemNotFoundException;
use App\Job\JobItems\Exceptions\JobItemCreateErrorException;
use App\Job\JobItems\Exceptions\JobItemUpdateErrorException;
use App\Job\JobItems\Repositories\JobItemRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobItemUnitTest extends TestCase
{
  /** @test */
  public function it_can_list_all_the_jobitems()
  {
    $jobItemRepo = new JobItemRepository(new JobItem);
    $jobItems = $jobItemRepo->listJobItems();

    $this->assertGreaterThan(0, $jobItems->count());
  }

  /** @test */
  public function it_can_count_active_jobitems()
  {
    $jobItemRepo = new JobItemRepository(new JobItem);
    $jobitemCount = $jobItemRepo->listJobitemCount();

    $this->assertGreaterThan(0, $jobitemCount);
  }

  /** @test */
  public function it_errors_creating_the_job_item_when_required_fields_are_not_passed()
  {
    $this->expectException(JobItemCreateErrorException::class);

    $jobitem = new JobItemRepository(new JobItem);
    $jobitem->createJobItem([]);
  }

  /** @test */
  public function it_can_create_a_job_item()
  {
    $image = UploadedFile::fake()->image('file.png', 600, 400);

    $params = [
      'company_id' => 1,
      'employer_id' => 1,
      'status' => 0,
      'job_title' => $this->faker->sentence,
      'job_img' => $image,
      'status_cat_id' => 1,
      'type_cat_id' => 1,
      'area_cat_id' => 1,
      'hourly_salary_cat_id' => 1,
      'date_cat_id' => 1
    ];

    $jobitem = new JobItemRepository(new JobItem);
    $created = $jobitem->createJobItem($params);

    $this->assertInstanceOf(JobItem::class, $created);
    $this->assertEquals($params['company_id'], $created->company_id);
    $this->assertEquals($params['employer_id'], $created->employer_id);
    $this->assertEquals($params['status'], $created->status);
    $this->assertEquals($params['job_title'], $created->job_title);
    $this->assertEquals($params['job_img'], $created->job_img);
    $this->assertEquals($params['status_cat_id'], $created->status_cat_id);
    $this->assertEquals($params['type_cat_id'], $created->type_cat_id);
    $this->assertEquals($params['area_cat_id'], $created->area_cat_id);
    $this->assertEquals($params['hourly_salary_cat_id'], $created->hourly_salary_cat_id);
    $this->assertEquals($params['date_cat_id'], $created->date_cat_id);
  }

  /** @test */
  public function it_errors_updating_the_jobitem_with_required_fields_are_not_passed()
  {
    $this->expectException(JobItemUpdateErrorException::class);

    $jobitem = new JobItemRepository($this->jobitem);
    $jobitem->updateJobItem(['employer_id' => null]);
  }

  /** @test */
  public function it_can_update_a_jobitem()
  {
    $jobitem = factory(JobItem::class)->create();
    $jobitemTitle = 'testTitle';
    $image = UploadedFile::fake()->image('file.png', 600, 400);

    $data = [
      'job_title' => $jobitemTitle,
      'job_img' => $image,
      'status' => 1
    ];

    $jobitemRepo = new JobItemRepository($jobitem);
    $updated = $jobitemRepo->updateJobItem($data);

    $this->assertTrue($updated);
  }

  /** @test */
  public function it_can_create_recent_jobitem_id_list()
  {
    $jobitem = factory(JobItem::class)->create();
    $jobItemRepo = new JobItemRepository($jobitem);

    $response = $this->get('/');

    $symfonyRequest = Request::create(
      route('top.get'),
      'GET',
      [],
      [],
      [],
      []
    );
    $request = Request::createFromBase($symfonyRequest);

    $jobItemRepo->createRecentJobItemIdList($request, $jobitem->id);

    $response->assertSessionHas('recent_jobs');
  }

  /** @test */
  public function it_can_list_recent_jobitem_id()
  {

    $jobItemRepo = new JobItemRepository(new JobItem);

    $results = $jobItemRepo->listRecentJobItemId();

    $this->assertEmpty($results);
  }

  /** @test */
  public function it_can_find_the_jobitem()
  {
    $jobitem = new JobItemRepository(new JobItem);
    $found = $jobitem->findJobItemById($this->jobitem->id);

    $this->assertInstanceOf(JobItem::class, $found);
    $this->assertEquals($this->jobitem->job_title, $found->job_title);
    $this->assertEquals($this->jobitem->job_type, $found->job_type);
    $this->assertEquals($this->jobitem->job_hourly_salary, $found->job_hourly_salary);
    $this->assertEquals($this->jobitem->job_office, $found->job_office);
    $this->assertEquals($this->jobitem->job_office_address, $found->job_office_address);
  }

  /** @test */
  public function it_can_find_all_jobitems()
  {
    $jobitem = new JobItemRepository(new JobItem);
    $found = $jobitem->findAllJobItemById($this->jobitem->id);

    $this->assertInstanceOf(JobItem::class, $found);
    $this->assertEquals($this->jobitem->job_title, $found->job_title);
    $this->assertEquals($this->jobitem->job_type, $found->job_type);
    $this->assertEquals($this->jobitem->job_hourly_salary, $found->job_hourly_salary);
    $this->assertEquals($this->jobitem->job_office, $found->job_office);
    $this->assertEquals($this->jobitem->job_office_address, $found->job_office_address);
  }

  /** @test */
  public function it_can_query_base_search_jobitems()
  {
    $jobItemRepo = new JobItemRepository($this->jobitem);
    $queryJobitems = $jobItemRepo->baseSearchJobItems($this->baseQueryData);
    $getJobitem = $queryJobitems->first();

    $this->assertIsObject($getJobitem);
    $this->assertEquals($getJobitem->job_title, $this->jobitem->job_title);

    return $queryJobitems;
  }

  /** @test **/
  public function it_can_exist_jobitem_image_and_delete_on_post()
  {
    $jobItemRepo = new JobItemRepository(new JobItem);
    $results = $jobItemRepo->existJobItemImageAndDeleteOnPost('main', 0);

    $this->assertEmpty($results);
  }

  /** @test **/
  public function it_can_get_job_image_base_url()
  {
    $jobItemRepo = new JobItemRepository(new JobItem);
    $baseUrl = $jobItemRepo->getJobImageBaseUrl();

    $this->assertEmpty($baseUrl);
  }
}
