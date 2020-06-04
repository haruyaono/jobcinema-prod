<?php

namespace App\Job\Employers\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Job\JobItems\JobItem;
use App\Job\Employers\Employer;
use App\Job\Employers\Repositories\Interfaces\EmployerRepositoryInterface;
use App\Job\Employers\Exceptions\CreateEmployerInvalidArgumentException;
use App\Job\Employers\Exceptions\EmployerNotFoundException;
use App\Job\Employers\Exceptions\UpdateEmployerInvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class EmployerRepository extends BaseRepository implements EmployerRepositoryInterface
{
    /**
     * EmployerRepository constructor.
     * @param Employer $employer
     */
    public function __construct(Employer $employer)
    {
        parent::__construct($employer);
        $this->model = $employer;
    }

    /**
     * Create the employer
     *
     * @param array $params
     * @return Employer
     * @throws CreateEmployerInvalidArgumentException
     */
    public function createEmployer(array $params) : Employer
    {
        try {
            $data = collect($params)->except('password')->all();

            $employer = new Employer($data);
            if (isset($params['password'])) {
                $employer->password = bcrypt($params['password']);
            }
            if (isset($params['email'])) {
                $employer->email_verify_token = base64_encode($params['email']);
            }

            $employer->save();

            return $employer;
        } catch (QueryException $e) {
            throw new CreateEmployerInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Update the employer
     * 
     * @param array $params
     * 
     * @return bool
     * 
     * @throws UpdateEmployerInvalidArgumentException
     */
    public function updateEmployer(array $params) : bool
    {
        try {
            return $this->model->update($params);
        } catch (QueryException $e) {
            throw new UpdateEmployerInvalidArgumentException($e);
        }
    }

    /**
     * Find the employer or fail
     *
     * @param int $id
     *
     * @return Employer
     * @throws EmployerNotFoundException
     */
    public function findEmployerById(int $id) : Employer
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new EmployerNotFoundException($e);
        }
    }

    /** 
     * Delete a employer 
     * 
     * @return  bool
     * @throws \Exception
     */
    public function deleteEmployer() :bool
    {
        return $this->delete();
    }
    
    /**
     * @param array $employer
     *
     * @return mixed
     */
    public function findCompanies(Employer $employer) : Collection
    {
        return $employer->company;
    }

    /**
     * @param array $employer
     *
     * @return mixed
     */
    public function findJobItems(Employer $employer) : Collection
    {
        return $employer->jobs;
    }

     

   
}