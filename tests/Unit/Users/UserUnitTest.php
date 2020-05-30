<?php

namespace Tests\Unit\Users;

use App\Shop\Addresses\Address;
use App\Job\Users\User;
use App\Job\Users\Exceptions\CreateUserInvalidArgumentException;
use App\Job\Users\Exceptions\UserNotFoundException;
use App\Job\Users\Exceptions\UpdateUserInvalidArgumentException;
use App\Job\Users\Repositories\UserRepository;
// use App\Job\Users\Transformations\UserTransformable;
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
 
}
