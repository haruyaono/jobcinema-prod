<?php

namespace App\Job\Employers\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Job\Employers\Employer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface EmployerRepositoryInterface extends BaseRepositoryInterface
{ 

   public function createEmployer(array $params) : Employer;

   public function updateEmployer(array $params) : bool;

   public function findEmployerById(int $id) : Employer;

   public function deleteEmployer() :bool;

   public function findCompanies(Employer $employer) : Collection;

   public function findJobItems(Employer $employer) : Collection;
 
}