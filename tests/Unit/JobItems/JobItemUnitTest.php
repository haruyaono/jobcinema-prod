<?php

namespace Tests\Unit\JobItems;

use App\Job\JobItems\JobItem;
use App\Job\JobItems\Exceptions\JobItemNotFoundException;
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
