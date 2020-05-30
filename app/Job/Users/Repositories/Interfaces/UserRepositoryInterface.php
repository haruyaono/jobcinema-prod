<?php

namespace App\Job\Users\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Job\Users\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface extends BaseRepositoryInterface
{ 

   public function createUser(array $params) : User;

   public function updateUser(array $params) : bool; 

   public function findUserById(int $id) : User;
   
 
}