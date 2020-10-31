<?php

namespace Tests\Unit\Profiles;

use App\Job\Users\User;
use App\Job\Profiles\Profile;
use App\Job\Profiles\Exceptions\CreateProfileErrorException;
use App\Job\Profiles\Exceptions\ProfileNotFoundException;
use App\Job\Profiles\Repositories\ProfileRepository;
use Tests\TestCase;

class ProfileUnitTest extends TestCase
{
    /** @test */
    public function it_errors_when_the_profile_is_not_found()
    {
        $this->expectException(ProfileNotFoundException::class);

        $profile = new ProfileRepository(new Profile);
        $profile->findProfileById(999);
    }

    /** @test */
    public function it_errors_when_creating_a_profile()
    {
        $this->expectException(CreateProfileErrorException::class);

        $profile = new ProfileRepository(new Profile);
        $profile->createProfile([]);
    }

    /** @test */
    public function it_can_update_the_profile()
    {

        $profile = factory(Profile::class)->create();

        $data = [
            'postcode' => $this->faker->postcode,
            'city' => $this->faker->city,
            'occupation' => $this->faker->jobTitle,
            'final_education' => $this->faker->sentence
        ];

        $profileRepo = new ProfileRepository($profile);
        $updated = $profileRepo->updateProfile($data);

        $profile = $profileRepo->findProfileById($profile->id);

        $this->assertTrue($updated);
        $this->assertEquals($data['postcode'], $profile->postcode);
        $this->assertEquals($data['city'], $profile->city);
        $this->assertEquals($data['occupation'], $profile->occupation);
        $this->assertEquals($data['final_education'], $profile->final_education);
    }

    /** @test */
    public function it_can_soft_delete_the_profile()
    {
        $created = factory(Profile::class)->create();

        $profile = new ProfileRepository($created);
        $profile->deleteProfile();

        $this->assertDatabaseHas('profiles', ['id' => $created->id]);
    }

    /** @test */
    public function it_can_create_the_profile()
    {
        $user = factory(User::class)->create();

        $data = [
            'user_id' => $user->id,
            'postcode' => $this->faker->postcode,
            'city' => $this->faker->city,
            'occupation' => $this->faker->jobTitle,
            'final_education' => $this->faker->sentence
        ];

        $profileRepo = new ProfileRepository(new Profile);
        $profile = $profileRepo->createProfile($data);

        $this->assertInstanceOf(Profile::class, $profile);
        $this->assertEquals($data['postcode'], $profile->postcode);
        $this->assertEquals($data['city'], $profile->city);
        $this->assertEquals($data['occupation'], $profile->occupation);
        $this->assertEquals($data['final_education'], $profile->final_education);
    }
}
