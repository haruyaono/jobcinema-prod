<?php

namespace Tests\Unit\Applies;

use App\Job\JobItems\JobItem;
use App\Job\Applies\Apply;
use App\Job\Users\User;
use App\Job\Applies\Exceptions\ApplyNotFoundException;
use App\Job\Applies\Exceptions\ApplyInvalidArgumentException;
use App\Job\Applies\Repositories\ApplyRepository;
use Tests\TestCase;

class ApplyUnitTest extends TestCase
{
   /** @test */
   public function it_can_associate_the_jobitem_in_the_apply()
   {
       $jobitem = factory(JobItem::class)->create();
       $apply = factory(Apply::class)->create();

       $applyRepo = new ApplyRepository($apply);
       $applyRepo->associateJobItem($jobitem);

       $jobitems = $applyRepo->findJobItems($apply);

       foreach ($jobitems as $p) {
           $this->assertEquals($jobitem->job_title, $p->job_title);
           $this->assertEquals($jobitem->job_type, $p->job_type);
           $this->assertEquals($jobitem->job_office, $p->job_office);
       }
   }

   /** @test */
   public function it_can_list_all_the_applies()  
   {
      $user = factory(User::class)->create();

      $data = [
          'user_id' => $user->id,
          'last_name' => $this->faker->lastName,
          'first_name' => $this->faker->firstName,
          'postcode' => $this->faker->postcode,
          'prefecture' => $this->faker->country,
          'city' => $this->faker->city,
          'gender' => $this->faker->titleMale,
          'age' =>  $this->faker->numberBetween(18, 99),
          'phone1' => '080',
          'phone2' =>  '1122',
          'phone3' =>  '3344',
          'occupation' => $this->faker->jobTitle,
          'final_education' => $this->faker->sentence,
          'work_start_date' => $this->faker->sentence,
      ];

      $jobitem = factory(JobItem::class)->create();

      $applyRepo = new ApplyRepository(new Apply);
      $apply = $applyRepo->createApply($data, $jobitem->id);

      $applyRepo = new ApplyRepository($apply);
      $applyRepo->associateJobItem($jobitem);

      $lists = $applyRepo->listApplies();

      foreach ($lists as $found) {
        $this->assertEquals($data['last_name'], $found->last_name);
        $this->assertEquals($data['first_name'], $found->first_name);
        $this->assertEquals($data['postcode'], $found->postcode);
        $this->assertEquals($data['prefecture'], $found->prefecture);
        $this->assertEquals($data['city'], $found->city);
      }
   }

   /** @test */
   public function it_errors_looking_for_the_apply_that_is_not_found()
   {
       $this->expectException(ApplyNotFoundException::class);

       $applyRepo = new ApplyRepository(new Apply);
       $applyRepo->findApplyById(999);
   }

    /** @test */
    public function it_can_get_the_apply()
    {
        $user = factory(User::class)->create();
        $jobitem = factory(JobItem::class)->create();

        $data = [
          'user_id' => $user->id,
          'last_name' => $this->faker->lastName,
          'first_name' => $this->faker->firstName,
          'postcode' => $this->faker->postcode,
          'prefecture' => $this->faker->country,
          'city' => $this->faker->city,
          'gender' => $this->faker->titleMale,
          'age' =>  $this->faker->numberBetween(18, 99),
          'phone1' => '080',
          'phone2' =>  '1122',
          'phone3' =>  '3344',
          'occupation' => $this->faker->jobTitle,
          'final_education' => $this->faker->sentence,
          'work_start_date' => $this->faker->sentence,
        ];

        $applyRepo = new ApplyRepository(new Apply);
        $created = $applyRepo->createApply($data, $jobitem->id);

        $found = $applyRepo->findApplyById($created->id);

        $this->assertEquals($data['last_name'], $found->last_name);
        $this->assertEquals($data['first_name'], $found->first_name);
        $this->assertEquals($data['postcode'], $found->postcode);
        $this->assertEquals($data['prefecture'], $found->prefecture);
        $this->assertEquals($data['city'], $found->city);
    }

     /** @test */
     public function it_errors_when_the_required_fields_are_not_passed()
     {
         $this->expectException(ApplyInvalidArgumentException::class);
 
         $user = factory(User::class)->create();
         $jobitem = factory(JobItem::class)->create();
 
         $data = [
            'user_id' => $user->id,
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'postcode' => $this->faker->postcode,
            'prefecture' => $this->faker->country,
            'city' => $this->faker->city,
            'gender' => $this->faker->titleMale,
            'age' =>  $this->faker->numberBetween(18, 99),
            'phone1' => '080',
            'phone2' =>  '1122',
            'phone3' =>  '3344',
            'occupation' => $this->faker->jobTitle,
            'final_education' => $this->faker->sentence,
         ];
 
         $applyRepo = new ApplyRepository(new Apply);
         $applyRepo->createApply($data, $jobitem->id);
     }
      
     /** @test */
    public function it_errors_when_foreign_keys_are_not_found()
    {
        $this->expectException(ApplyInvalidArgumentException::class);

        $jobitem = factory(JobItem::class)->create();

        $data = [
          'last_name' => $this->faker->lastName,
          'first_name' => $this->faker->firstName,
          'postcode' => $this->faker->postcode,
          'prefecture' => $this->faker->country,
          'city' => $this->faker->city,
          'gender' => $this->faker->titleMale,
          'age' =>  $this->faker->numberBetween(18, 99),
          'phone1' => '080',
          'phone2' =>  '1122',
          'phone3' =>  '3344',
          'occupation' => $this->faker->jobTitle,
          'final_education' => $this->faker->sentence,
          'work_start_date' => $this->faker->sentence,
        ];

        $applyRepo = new ApplyRepository(new Apply);
        $applyRepo->createApply($data, $jobitem->id);
    }

     /** @test */
     public function it_can_create_an_apply()
     {
        $user = factory(User::class)->create();
        $jobitem = factory(JobItem::class)->create();
 
        $data = [
          'user_id' => $user->id,
          'last_name' => $this->faker->lastName,
          'first_name' => $this->faker->firstName,
          'postcode' => $this->faker->postcode,
          'prefecture' => $this->faker->country,
          'city' => $this->faker->city,
          'gender' => $this->faker->titleMale,
          'age' =>  $this->faker->numberBetween(18, 99),
          'phone1' => '080',
          'phone2' =>  '1122',
          'phone3' =>  '3344',
          'occupation' => $this->faker->jobTitle,
          'final_education' => $this->faker->sentence,
          'work_start_date' => $this->faker->sentence,
        ];
 
        $applyRepo = new ApplyRepository(new Apply);
        $created = $applyRepo->createApply($data, $jobitem->id);
 
        $this->assertEquals($data['user_id'], $user->id);
        $this->assertEquals($data['last_name'], $created->last_name);
        $this->assertEquals($data['first_name'], $created->first_name);
        $this->assertEquals($data['postcode'], $created->postcode);
        $this->assertEquals($data['prefecture'], $created->prefecture);
     }



}
