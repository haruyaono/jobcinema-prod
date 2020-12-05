<?php

namespace Tests\Unit\Users;

use App\Job\JobItems\JobItem;
use App\Job\JobItems\Repositories\JobItemRepository;
use App\Job\Applies\Apply;
use App\Job\Applies\Repositories\ApplyRepository;
use App\Job\Users\User;
use App\Job\Users\Exceptions\CreateUserInvalidArgumentException;
use App\Job\Users\Exceptions\UserNotFoundException;
use App\Job\Users\Exceptions\UpdateUserInvalidArgumentException;
use App\Job\Users\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserUnitTest extends TestCase
{

    /** @test */
    public function it_errors_updating_the_user_email_with_null_value()
    {
        $this->expectException(UpdateUserInvalidArgumentException::class);

        $userfac = factory(User::class)->create();

        $user = new UserRepository($userfac);
        $user->updateUser(['email' => null]);
    }

    /** @test */
    public function it_errors_creating_the_user()
    {
        $this->expectException(CreateUserInvalidArgumentException::class);
        $this->expectExceptionCode(500);

        $user = new UserRepository(new User);
        $user->createUser([]);
    }

    /** @test */
    public function it_can_update_users_password()
    {
        $userFac = factory(User::class)->create();

        $user = new UserRepository($userFac);
        $user->updateUser([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => 'unknown'
        ]);

        $this->assertTrue(Hash::check('unknown', bcrypt($userFac->password)));
    }

    /** @test */
    public function it_can_update_the_user()
    {
        $userFac = factory(User::class)->create();
        $user = new UserRepository($userFac);

        $update = [
            'first_name' => $this->faker->firstName,
        ];

        $updated = $user->updateUser($update);

        $this->assertTrue($updated);
        $this->assertEquals($update['first_name'], $userFac->first_name);
        $this->assertDatabaseHas('users', $update);
    }

    /** @test  */
    public function it_can_find_a_user()
    {

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => 'secret'
        ];

        $user = new UserRepository(new User);
        $created = $user->createUser($data);

        $found =  $user->findUserById($created->id);

        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($data['first_name'], $found->first_name);
        $this->assertEquals($data['last_name'], $found->last_name);
        $this->assertEquals($data['email'], $found->email);
    }

    /** @test */
    public function it_fails_when_the_user_is_not_found()
    {
        $this->expectException(UserNotFoundException::class);

        $user = new UserRepository(new User);
        $user->findUserById(999);
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => 'secret'
        ];

        $user = new UserRepository(new User);
        $created = $user->createUser($data);

        $this->assertInstanceOf(User::class, $created);
        $this->assertEquals($data['first_name'], $created->first_name);
        $this->assertEquals($data['last_name'], $created->last_name);
        $this->assertEquals($data['email'], $created->email);

        $collection = collect($data)->except('password');

        $this->assertDatabaseHas('users', $collection->all());
    }

    /** @test */
    public function it_can_soft_delete_a_user()
    {
        $user = factory(User::class)->create();
        $userRepo = new UserRepository($user);

        $delete = $userRepo->deleteUser();

        $this->assertTrue($delete);
        $this->assertDatabaseHas('users', $user->toArray());
    }


    /** @test */
    //   public function it_can_return_all_the_applies_of_the_user()
    //   {
    //     $user = factory(User::class)->create();

    //     $apply = factory(Apply::class)->create([
    //         'user_id' => $user->id
    //     ]);

    //     $repo = new UserRepository($user);
    //     $applies = $repo->findApplies($user);

    //     $this->assertInstanceOf(Collection::class, $applies);

    //     foreach ($applies as $o) {
    //         $this->assertEquals($apply->id, $o->id);
    //         $this->assertEquals($user->id, $o->user_id);
    //     }
    //  }

    /** @test */
    public function it_exists_applied_jobitem_of_the_user()
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


        $repo = new UserRepository($user);
        $result = $repo->existsAppliedJobItem($user, $jobitem->id);

        $this->assertTrue($result);
    }

    /** @test */
    public function it_list_applied_jobitem_of_the_user()
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


        $repo = new UserRepository($user);
        $result = $repo->listAppliedJobItem($user);

        $this->assertIsObject($result);
    }
}
