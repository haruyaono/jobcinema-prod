<?php

namespace App\Job\Companies\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Job\Employers\Employer;
use App\Job\Companies\Company;
use App\Job\Companies\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Job\Companies\Exceptions\CreateCompanyErrorException;
use App\Job\Companies\Exceptions\CompanyNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    /**
     * CompanyRepository constructor.
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        parent::__construct($company);
        $this->model = $company;
    }

    /**
     * List all the companies
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @param string $active
     * @return Collection
     */
    public function listCompanies(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
            return $this->all($columns, $order, $sort);
    }

      /**
     * Create the company
     *
     * @param array $data 
     *
     * @return Company
     * @throws CreateCompanyErrorException
     */
    public function createCompany(array $data) : Company
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateCompanyErrorException('会社情報の作成に失敗しました。');
        }
    }

    /**
     * @param array $data
     * @return bool
     */
    public function updateCompany(array $data): bool
    {
        return $this->update($data);
    }

    /**
     * Soft delete the company
     * 
     * @return bool
     * @throws \Exception
     */
    public function deleteCompany() : bool
    {
        return $this->delete();
    }

    /**
     * Return the company
     * 
     * @param int $id
     * 
     * @return Company
     * @throws CompanyNotFoundException
     */
    public function findCompanyById(int $id) : Company
    {
        try
        {
            return $this->findOneOrFail($id);
        } 
        catch (ModelNotFoundException $e)
        {
            throw new CompanyNotFoundException('会社情報が見つかりませんでした。');
        }
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function searchCompany(string $orderBy = 'created_at', string $sortBy = 'desc', $columns = ['*']) : Collection
    {
        return $this->orderBy($orderBy, $sortBy)->get($columns);
    }
   
}