<?php

namespace App\Job\Admins\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Job\Admins\Admin;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AdminRepositoryInterface extends BaseRepositoryInterface
{ 

   public function sendEmailToEmployer($jobitem, $slug);
   
 
}