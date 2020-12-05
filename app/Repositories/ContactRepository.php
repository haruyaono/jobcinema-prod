<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Mail\SendContactMailable;
use Illuminate\Support\Facades\Mail;

class ContactRepository extends AbstractRepository
{
    public function getModelClass(): string
    {
        return Contact::class;
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
