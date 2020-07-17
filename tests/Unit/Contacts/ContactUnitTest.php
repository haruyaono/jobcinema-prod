<?php

namespace Tests\Unit\Contacts;

use App\Mail\SendContactMailable;
use App\Job\Contacts\Contact;
use App\Job\Contacts\Exceptions\CreateContactErrorException;
use App\Job\Contacts\Repositories\ContactRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactUnitTest extends TestCase
{

      /** @test */
      public function it_errors_when_creating_a_contact()
      {
          $this->expectException(CreateContactErrorException::class);
  
          $contact = new ContactRepository(new Contact);
          $contact->createContact([]);
      }

    /** @test */
    public function it_can_create_a_contact()
    {
        $contact = factory(Contact::class)->create();

        $data = [
            'division' => 'seeker',
            'category' => $this->faker->word,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' =>  $this->faker->phoneNumber,
            'content' => $this->faker->text,
        ];

        $contactRepo = new ContactRepository(new Contact);
        $created = $contactRepo->createContact($data);

        $this->assertEquals($data['category'], $created->category);
        $this->assertEquals($data['name'], $created->name);
        $this->assertEquals($data['email'], $created->email);
        $this->assertEquals($data['phone'], $created->phone);
        $this->assertEquals($data['content'], $created->content);
    }
 
}
