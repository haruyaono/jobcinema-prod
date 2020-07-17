<?php

namespace App\Job\Contacts\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Job\Contacts\Contact;
use Illuminate\Support\Collection;

interface ContactRepositoryInterface extends BaseRepositoryInterface
{  

    public function createContact(array $data) : Contact;

    public function sendEmailToSeeker($data);

    public function sendEmailToEmployer($data);

    public function sendEmailToAdmin($data, $viewStr = '');
}