<?php

namespace App\Job\Companies\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Job\Companies\Company;
use App\Job\Employers\Employer;
use Illuminate\Support\Collection;

interface CompanyRepositoryInterface extends BaseRepositoryInterface
{  

    public function createCompany(array $data) : Company;

    public function updateCompany(array $data): bool;

    public function deleteCompany() : bool;

    public function findCompanyById(int $id) : Company;
}