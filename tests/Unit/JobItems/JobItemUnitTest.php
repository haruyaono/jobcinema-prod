<?php

namespace Tests\Unit\JobItems;

use App\Job\Employers\Employer;
use App\Job\Applies\Apply;
use App\Job\Applies\Repositories\ApplyRepository;
use App\Job\JobItems\JobItem;
use App\Job\JobItems\Exceptions\JobItemNotFoundException;
use App\Job\JobItems\Exceptions\AppliedJobItemNotFoundException;
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

      /** @test  */
    public function it_can_find_an_applied_jobitem() 
    {

      $employer = factory(Employer::class)->create();
      $apply = factory(Apply::class)->create();
      $jobitem = factory(JobItem::class)->create();

      $applyRepo = new ApplyRepository($apply);
      $applyRepo->associateJobItem($jobitem);

      $param = [
        'job_item_id' => $jobitem->id
      ];

      $jobitemRepo = new JobItemRepository($jobitem);
      $result = $jobitemRepo->findAppliedJobItem($param);

      $this->assertIsObject($result);
    }

    /** @test */
    public function it_fails_when_the_applied_jobitem_is_not_found()
    {
        $this->expectException(AppliedJobItemNotFoundException::class);

        $jobitemRepo = new JobItemRepository(new JobItem);
        $jobitemRepo->findAppliedJobItem(['id' => 999]);
    }

      /** @test */
      public function it_can_create_recent_jobitem_id_list()
      {
        $jobitem = factory(JobItem::class)->create();
        $jobItemRepo = new JobItemRepository($jobitem);

        $response = $this->get('/');

        $symfonyRequest = Request::create(
            route('top.get'), 'GET', [], [], [], []
        );
        $request = Request::createFromBase($symfonyRequest);

        $jobItemRepo->createRecentJobItemIdList($request, $jobitem->id);

        $response->assertSessionHas('recent_jobs');
      }

      /** @test */
      public function it_can_list_recent_jobitem_id()
      {
       
        $jobItemRepo = new JobItemRepository( new JobItem );

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
       public function it_can_query_base_search_jobitems()
       {
            $jobItemRepo = new JobItemRepository($this->jobitem);
            $queryJobitems = $jobItemRepo->baseSearchJobItems($this->baseQueryData);
            $getJobitem = $queryJobitems->first();

            $this->assertIsObject($getJobitem);
            $this->assertEquals($getJobitem->job_title, $this->jobitem->job_title);

            return $queryJobitems;
       }

        /** @depends it_can_query_base_search_jobitems */
        public function it_can_sort_jobitems(array $queryJobitems)
        {
             $jobItemRepo = new JobItemRepository(new JobItem);
             $queryJobitems = $jobItemRepo->getSortJobItems($queryJobitems, 'hourly_salary_cat_id');
             $getJobitem = $queryJobitems->first();
 
             $this->assertIsObject($getJobitem);
             $this->assertEquals($getJobitem->job_title, $this->jobitem->job_title);
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
