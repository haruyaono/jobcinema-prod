<?php

namespace App\Job\Contacts\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Job\Contacts\Contact;
use App\Job\Contacts\Repositories\Interfaces\ContactRepositoryInterface;
use App\Mail\SendContactMailable;
use App\Job\Contacts\Exceptions\CreateContactErrorException;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    /**
     * ContactRepository constructor.
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        parent::__construct($contact);
        $this->model = $contact;
    }

      /**
     * Create the contact
     *
     * @param array $data
     *
     * @return Contact
     * @throws CreateContactErrorException
     */
    public function createContact(array $data) : Contact
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateContactErrorException('お問い合わせの通信に失敗しました。');
        }
    }

    /**
     * send email to seeker
     */
    public function sendEmailToSeeker($data)
    {
        Mail::queue(new SendContactMailable($data));
    }

    /**
     * send email to employer
     */
    public function sendEmailToEmployer($data)
    {
        Mail::queue(new SendContactMailable($data));
    }

     /**
     * send email to admin
     */
    public function sendEmailToAdmin($data, $viewStr = '') 
    {
        Mail::queue(new SendContactMailable($data, $viewStr));
    }

}