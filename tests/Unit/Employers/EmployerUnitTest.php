<?php

namespace Tests\Unit\Employers;

use App\Job\JobItems\JobItem;
use App\Job\JobItems\Repositories\JobItemRepository;
use App\Job\Employers\Employer;
use App\Job\Employers\Exceptions\CreateEmployerInvalidArgumentException;
use App\Job\Employers\Exceptions\EmployerNotFoundException;
use App\Job\Employers\Exceptions\UpdateEmployerInvalidArgumentException;
use App\Job\Employers\Repositories\EmployerRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EmployersUnitTest extends TestCase
{

     /** @test */
     public function it_errors_updating_the_employer_email_with_null_value()
     {
         $this->expectException(UpdateEmployerInvalidArgumentException::class);
 
         $employerFac = factory(Employer::class)->create();
 
         $employer = new EmployerRepository($employerFac);
         $employer->updateEmployer(['email' => null]);
     }

    /** @test */
    public function it_errors_creating_the_employer()
    {
        $this->expectException(CreateEmployerInvalidArgumentException::class);
        $this->expectExceptionCode(500);

        $employer = new EmployerRepository(new Employer);
        $employer->createEmployer([]);
    }

    /** @test */
    public function it_can_update_employers_password()
    {
        $employerFac = factory(Employer::class)->create();

        $employer = new EmployerRepository($employerFac);
        $employer->updateEmployer([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => 'unknown'
        ]);

        $this->assertTrue(Hash::check('unknown', bcrypt($employerFac->password)));
    }

    /** @test */
    public function it_can_update_the_employer() 
    {
        $employerFac = factory(Employer::class)->create();
        $employer = new EmployerRepository($employerFac);

        $update = [
            'first_name' => $this->faker->firstName,
        ];

        $updated = $employer->updateEmployer($update);

        $this->assertTrue($updated);
        $this->assertEquals($update['first_name'], $employerFac->first_name);
        $this->assertDatabaseHas('employers', $update);
    }

    /** @test  */
    public function it_can_find_an_employer() 
    {

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => 'secret'
        ];

        $employer = new EmployerRepository(new Employer);
        $created = $employer->createEmployer($data);

        $found =  $employer->findEmployerById($created->id);

        $this->assertInstanceOf(Employer::class, $found);
        $this->assertEquals($data['first_name'], $found->first_name);
        $this->assertEquals($data['last_name'], $found->last_name);
        $this->assertEquals($data['email'], $found->email);
    }

    /** @test */
    public function it_fails_when_the_employer_is_not_found()
    {
        $this->expectException(EmployerNotFoundException::class);

        $employer = new EmployerRepository(new Employer);
        $employer->findEmployerById(999);
    }

     /** @test */
     public function it_can_create_an_employer()
     {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => 'secret'
        ];
 
        $employer = new EmployerRepository(new Employer);
        $created = $employer->createEmployer($data);

        $this->assertInstanceOf(Employer::class, $created);
        $this->assertEquals($data['first_name'], $created->first_name);
        $this->assertEquals($data['last_name'], $created->last_name);
        $this->assertEquals($data['email'], $created->email);

        $collection = collect($data)->except('password');

        $this->assertDatabaseHas('employers', $collection->all());
    }

    /** @test */
    public function it_can_soft_delete_an_employer()
    {
        $employer = factory(Employer::class)->create();
        $employerRepo = new EmployerRepository($employer);

        $delete = $employerRepo->deleteEmployer();

        $this->assertTrue($delete);
        $this->assertDatabaseHas('employers', $employer->toArray());
    }
 
}
