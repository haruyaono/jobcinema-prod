<?php

namespace App\Job\Admins\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Job\JobItems\JobItem;
use App\Mail\SendJobAdoptToCustomerMailable;
use App\Mail\SendJobUnAdoptToCustomerMailable;
use App\Mail\SendJobUnPublicToCustomerMailable;
use App\Job\Admins\Admin;
use App\Job\Admins\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    /**
     * AdminRepository constructor.
     * @param Admin $admin
     */
    public function __construct(Admin $admin)
    {
        parent::__construct($admin);
        $this->model = $admin;
    }

     /**
     * Send email to employer
     */
    public function sendEmailToEmployer($jobitem, $slug)
    {

        switch($slug) {
            case 'status_approve':
                $mail = new SendJobAdoptToCustomerMailable($jobitem);
                break;
            case 'status_non_approve':
                $mail = new SendJobUnAdoptToCustomerMailable($jobitem);
                break;
            case 'status_non_public':
                $mail = new SendJobUnPublicToCustomerMailable($jobitem);
                break;
            default:
                $mail = '';
        }

        Mail::to($jobitem->employer)->queue($mail);
    }

   
}