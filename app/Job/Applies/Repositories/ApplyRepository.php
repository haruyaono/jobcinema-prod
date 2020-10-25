<?php

namespace App\Job\Applies\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Job\JobItems\JobItem;
use App\Job\Applies\Apply;
use App\Job\Applies\Repositories\Interfaces\ApplyRepositoryInterface;
use App\Job\Applies\Exceptions\ApplyNotFoundException;
use App\Job\Applies\Exceptions\ApplyInvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class ApplyRepository extends BaseRepository implements ApplyRepositoryInterface
{
    /**
     * ApplyRepository constructor.
     * @param Apply $apply
     */
    public function __construct(Apply $apply)
    {
        parent::__construct($apply);
        $this->model = $apply;
    }

    /**
     * Create the apply
     *
     * @param array $params
     * @return Apply
     * @throws ApplyInvalidArgumentException
     */
    public function createApply(array $params): Apply
    {
        try {
            $apply = $this->create($params);
            return $apply;
        } catch (QueryException $e) {
            throw new ApplyInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Find the apply or fail
     *
     * @param int $id
     *
     * @return Apply
     * @throws ApplyNotFoundException
     */
    public function findApplyById(int $id): Apply
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ApplyNotFoundException($e);
        }
    }

    /**
     * Return all the applies
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listApplies(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param Apply $apply
     * @return mixed
     */
    public function findJobItems(Apply $apply): Collection
    {
        return $apply->jobitems;
    }
}
